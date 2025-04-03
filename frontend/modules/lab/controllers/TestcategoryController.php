<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Testcategory;
use common\models\lab\TestcategorySearch;
use common\models\lab\Labsampletype;
use common\models\lab\LabsampletypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestcategoryController implements the CRUD actions for Testcategory model.
 */
class TestcategoryController extends Controller
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
     * Lists all Testcategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestcategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['category' => SORT_DESC];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategory()
    {
        $searchModel = new LabsampletypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['effective_date' => SORT_DESC];

        return $this->render('/labsampletype/indexcategory', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Testcategory model.
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
     * Creates a new Testcategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Testcategory();
        
                $post= Yii::$app->request->post();
                if ($model->load(Yii::$app->request->post())) {
                    $testcategory = Testcategory::find()->where(['category'=> $post['Testcategory']['category']])->one();
                         if ($testcategory){
                            // Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                              return $this->runAction('index');
                         }else{
                             $model->save();
                           //  Yii::$app->session->setFlash('success', 'Test Category Successfully Created'); 
                             return $this->runAction('index');
                         }      
        
                        }
         
                if(Yii::$app->request->isAjax){
                    return $this->renderAjax('_form', [
                        'model' => $model,
                    ]);
               }
    }

    public function actionCreatecategory()
    {
        $model = new Testcategory();
        
                $post= Yii::$app->request->post();
                if ($model->load(Yii::$app->request->post())) {
                    $testcategory = Testcategory::find()->where(['category'=> $post['Testcategory']['category']])->one();
                         if ($testcategory){
                            // Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                              return $this->runAction('category');
                         }else{
                             $model->save();
                             return $this->runAction('category');
                         }      
        
                        }

                        
                if(Yii::$app->request->isAjax){
                    return $this->renderAjax('_form', [
                        'model' => $model,
                    ]);
               }
         
    }

    /**
     * Updates an existing Testcategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                   // Yii::$app->session->setFlash('success', 'Test Category Successfully Updated'); 
                    return $this->redirect(['index']);

                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('update', [
                        'model' => $model,
                    ]);
                 }
    }

    /**
     * Deletes an existing Testcategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
        if($model->delete()) {            
           // Yii::$app->session->setFlash('success', 'Test Category Successfully Deleted'); 
            return $this->redirect(['index']);
        } else {
            return $model->error();
        }
    }

    /**
     * Finds the Testcategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testcategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testcategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
} 