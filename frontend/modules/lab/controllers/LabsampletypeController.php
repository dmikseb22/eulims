<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Labsampletype;
use common\models\lab\Sampletype;
use common\models\lab\LabsampletypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\models\system\Profile;
use DateTime;

/**
 * LabsampletypeController implements the CRUD actions for Labsampletype model.
 */
class LabsampletypeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Labsampletype models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LabsampletypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['effective_date' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Labsampletype model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]);
        }
    }

    /**
     * Creates a new Labsampletype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new Labsampletype();
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {

            $labsampletype = Labsampletype::find()->where(['lab_id'=> $post['Labsampletype']['lab_id'], 'sampletype_id'=>$post['Labsampletype']['sampletype_id'],  'testcategory_id'=>$post['Labsampletype']['testcategory_id']])->one();

            if ($labsampletype){
               // Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                 return $this->runAction('index');
            }else{
                $model->save();
               // Yii::$app->session->setFlash('success', 'Lab Sample Type Successfully Created'); 
                return $this->runAction('index');
            }
         
        }

        $sampletype = [];

        if(Yii::$app->request->isAjax){        
          $date2 = new DateTime();
          date_add($date2,date_interval_create_from_date_string("1 day"));
          $model->effective_date=date_format($date2,"Y-m-d");
          $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
          if($profile){
            $model->added_by=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
            }else{
                $model->added_by="";
            }

            return $this->renderAjax('_form', [
                'model' => $model,
                'sampletype'=>$sampletype,
            ]);
       }
  
    }

    /**
     * Updates an existing Labsampletype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
                if ($model->load(Yii::$app->request->post())) {
                    $post= Yii::$app->request->post();
                    $labsampletype = Labsampletype::find()->where(['lab_id'=> $post['Labsampletype']['lab_id'], 'sampletype_id'=>$post['Labsampletype']['sampletype_id'],  'testcategory_id'=>$post['Labsampletype']['testcategory_id']])->one();
                    if ($labsampletype){
                        Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                        return $this->redirect(['index']);
                    }else{        
                        $model->save();
                        return $this->redirect(['index']);
                    }
                  
                  


                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('update', [
                        'model' => $model,
                    ]);
                 }
    }
    /**
     * Deletes an existing Labsampletype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
                    if($model->delete()) {            
                       // Yii::$app->session->setFlash('success', 'Lab Sample Type Successfully Deleted'); 
                        return $this->redirect(['index']);
                    } else {
                        return $model->error();
                    }
    }

    /**
     * Finds the Labsampletype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Labsampletype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Labsampletype::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

  
}
