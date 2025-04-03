<?php

namespace frontend\modules\api\controllers;

use Yii;
use Datetime;
use frontend\modules\reports\modules\models\AccomplishmentRstl;
use frontend\modules\reports\modules\models\AccomplishmentRstlRealtime;
use frontend\modules\reports\modules\models\AccomplishmentOverall;
use frontend\modules\reports\modules\models\AccomplishmentOverallRealtime;
use yii\web\Response;
use api\components\Apicomponent;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\system\Profile;

class RealtimeupdateoverallController extends \yii\rest\Controller
{
     public $modelClass='frontend\modules\reports\modules\models\AccomplishmentOverall';
    public function actionIndex()
    {
        return $this->render('index');
    }
    
     public function actionRealtimedataoverall()
    {
        $paramID = Yii::$app->request->get('rstlid');
        $model = new $this->modelClass;  
  
        $rstlId = $paramID;// Yii::$app->user->identity->profile->rstl_id;
        $now = new DateTime();
        $currentyear=$now->format('Y');
        $currentmonth= $now->format('m');
        $currentmonthchar=strtolower($now->format('M'));
      
        $kpi = ['samples','tests','customers','newcustomers','firms','fees','csi'];
        foreach ($kpi as $kpirec)
        {
        Yii::$app->labdb->createCommand("CALL spUpdateAllTotalPerformance('" . $kpirec . "'," . $currentyear . ",'Accomplishments','". $rstlId ."');")->execute();
           
        }
       $provider = new ActiveDataProvider([
               //     'query' => $model->find()->Where('yeardata = 2020'),
            'query' => $model->find()->andWhere('yeardata = ' . $currentyear)->andWhere('type = "Accomplishments"'),
                    'pagination' => [
                     'defaultPageSize' => 100, // to set default count items on one page
                     'pageSize' => 50, //to set count items on one page, if not set will be set from defaultPageSize
                     'pageSizeLimit' => [1, 50] //to set range for pageSize 

             ],
                ]);
      	\Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
                return  $provider;

      


    }

}
