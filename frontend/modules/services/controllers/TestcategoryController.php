<?php

namespace frontend\modules\services\controllers;

use Yii;
use common\models\services\TestCategory;
use common\models\services\TestCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestcategoryController implements the CRUD actions for TestCategory model.
 */
class TestcategoryController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all TestCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestCategorySearch();
       // $transactions = $searchModel->searchbycustomerid($id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TestCategory model.
     * @param integer $id
     * @return mixed
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
     * Creates a new TestCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TestCategory();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                 Yii::$app->session->setFlash('success', 'Test Category Successfully Created'); 
                return $this->runAction('index');
        } 
          
       if(Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                        'model' => $model,
                    ]);
            }           
    }

    /**
     * Updates an existing TestCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Sample Type Successfully Updated'); 
            return $this->redirect(['view', 'id' => $model->testcategory_id]);
        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
         }
    }

    /**
     * Deletes an existing TestCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TestCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TestCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TestCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
