<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\testpackage;
use common\models\lab\TestpackageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestpackageController implements the CRUD actions for testpackage model.
 */
class TestpackageController extends Controller
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
     * Lists all testpackage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestpackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single testpackage model.
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
     * Creates a new testpackage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new testpackage();
        $sampletype = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Test Package Successfully Created'); 
            return $this->runAction('index');
        }

        if(Yii::$app->request->isAjax){
          
            return $this->renderAjax('_form', [
                'model' => $model,
                'sampletype' => $sampletype,
            ]);
       }


       
    }

    /**
     * Updates an existing testpackage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Test Package Successfully Updated'); 
                    return $this->redirect(['index']);

                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('update', [
                        'model' => $model,
                    ]);
                 }
    }

    /**
     * Deletes an existing testpackage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
        if($model->delete()) {            
            Yii::$app->session->setFlash('success', 'Test Package Successfully Deleted'); 
            return $this->redirect(['index']);
        } else {
            return $model->error();
        }
    }

    /**
     * Finds the testpackage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return testpackage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = testpackage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
