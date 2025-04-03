<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Sampletype;
use common\models\lab\SampletypeSearch;
use common\models\lab\LabsampletypeSearch;
use common\models\lab\SampletypetestnameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SampletypeController implements the CRUD actions for Sampletype model.
 */
class SampletypeController extends Controller
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
     * Lists all Sampletype models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SampletypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['type' => SORT_ASC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSampletypetestname()
    {
        $searchModel = new SampletypetestnameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/sampletypetestname/indexsampletypetestname', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSampletype()
    {
        $searchModel = new LabsampletypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/labsampletype/indexlab', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sampletype model.
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
     * Creates a new Sampletype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sampletype();
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {

          $sampletype = Sampletype::find()->where(['type'=> $post['Sampletype']['type']])->one();

          if ($sampletype){
            //Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
            return $this->runAction('index');
          }else{
            $model->save();  
            //Yii::$app->session->setFlash('success', 'Sample Type Successfully Created'); 
            return $this->runAction('index');
          }
         
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
            }

    }

    /**
     * Creates a new Sampletype model.
     * If creation is successful, the browser will be redirected to the 'testnamemethod/index' page.
     /*
        Created By: Bergel T. Cutara
        Contacts:

        Email: b.cutara@gmail.com
        Tel. Phone: (062) 991-1024
        Mobile Phone: (639) 956200353

        Description: This action is performed by the testnamemethod.
     * @return mixed
     */
    public function actionCreatebytestnamemethod()
    {
        $model = new Sampletype();
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {

          $sampletype = Sampletype::find()->where(['type'=> $post['Sampletype']['type']])->one();

          if ($sampletype){
            return $this->redirect(['/lab/testnamemethod']);
          }else{
            $model->save();
            return $this->redirect(['/lab/testnamemethod']);
          }
         
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }

    }

    public function actionCreatesampletype()
    {
        $model = new Sampletype();
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {

          $sampletype = Sampletype::find()->where(['type'=> $post['Sampletype']['type']])->one();

          if ($sampletype){
            //Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
            return $this->runAction('index');
          }else{
            $model->save();  
           // Yii::$app->session->setFlash('success', 'Sample Type Successfully Created'); 
            return $this->runAction('index');
          }
         
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_formsampletype', [
                'model' => $model,
            ]);
            }

    }

    public function actionCreatetype()
    {
        $model = new Sampletype();
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {

          $sampletype = Sampletype::find()->where(['type'=> $post['Sampletype']['type']])->one();

          if ($sampletype){
            Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
            return $this->runAction('sampletype');
          }else{
            $model->save();  
            Yii::$app->session->setFlash('success', 'Sample Type Successfully Created'); 
            return $this->runAction('sampletype');
          }
         
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_formsampletype', [
                'model' => $model,
            ]);
            }

    }

    /**
     * Updates an existing Sampletype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Sample Type Successfully Updated'); 
                    return $this->redirect(['index']);

                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('update', [
                        'model' => $model,
                    ]);
                 }
    }

    /**
     * Deletes an existing Sampletype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
        if($model->delete()) {            
            Yii::$app->session->setFlash('success', 'Sample Type Successfully Deleted'); 
            return $this->redirect(['index']);
        } else {
            return $model->error();
        }
    }

    /**
     * Finds the Sampletype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sampletype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sampletype::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
