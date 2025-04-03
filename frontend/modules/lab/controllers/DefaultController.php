<?php

namespace frontend\modules\lab\controllers;

use yii\web\Controller;
use Yii;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `Lab` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $todos = Sample::find()
        ->select([
            'sample_code' => 'tbl_sample.sample_code',
            'description' => 'tbl_request.report_due',
            'remarks' => 'testname',
            'package_id' => 'tbl_analysis.analysis_id',
            'customer_description'=>'tagging_status_id'
        ])
        ->innerJoinWith(['request'=> function($query){
            $today = date('Y-m-d');
            $nextthreedays=Date('Y-m-d', strtotime('+3 days'));
            $query->where(['between','report_due',$today,$nextthreedays]);
            $query->andWhere(['not', ['request_ref_num' => null]]);
        }])
        ->innerJoinWith(['analyses'=>function($query){
            $query->joinWith(['tagging'=>function($query){
                // $query->where(['<>','tagging_status_id','2']);
            }]);
        }])
        ->orderBy('description ASC,sample_code DESC , tbl_analysis.analysis_id ASC');


        $dataProvider = new ActiveDataProvider([
            'query' => $todos,
            'pagination'=>false
        ]);
        return $this->render('index',[
            'todoprovider'=>$dataProvider
        ]);
    }
}
