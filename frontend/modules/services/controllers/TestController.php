<?php

namespace frontend\modules\services\controllers;

use Yii;
use common\models\services\Test;
use common\models\lab\Request;
use common\models\lab\RequestSearch;
use common\models\lab\Testcategory;
use common\models\services\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
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
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Test model.
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
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        
     
        $model = new Test();
        $session = Yii::$app->session;

        if ($model->load(Yii::$app->request->post())) {

                      $model = new Test();
                      $post= Yii::$app->request->post();                    
                      $model->fee =  $post['Test']['fee'];
                      $model->lab_id =  $post['Test']['lab_id'];
                      $model->method = $post['Test']['method'];
                      $model->payment_references = $post['Test']['payment_references'];
                      $model->sample_type_id = $post['Test']['sample_type_id'];
                      $model->testcategory_id = $post['Test']['testcategory_id'];
                      $model->testname = $post['Test']['testname'];
                      $model->duration = 1;
                      $model->rstl_id = 1;

                     if ($model->save()){
                        Yii::$app->session->setFlash('success', 'Test Successfully created'); 
                        return $this->redirect('index');  
                     }else{
                        Yii::$app->session->setFlash('danger', 'Test not saved'); 
                        return $this->redirect('index');  
                     }          
                  }   
            
        $testcategory = $this->listTestcategory(1);
        $sampletype = [];

       if(Yii::$app->request->isAjax){
            return $this->renderAjax('_form', [
                'model' => $model,
                'testcategory'=>$testcategory,
                'sampletype'=>$sampletype,
            ]);
       }
       else{
            return $this->renderAjax('_form', [
                'model' => $model,
                'testcategory'=>$testcategory,
                'sampletype'=>$sampletype,
            ]);
       }
     }
    

    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           $session = Yii::$app->session;
           
            Yii::$app->session->setFlash('success', 'Test Successfully Updated'); 
            return $this->redirect('index');
        }

        $request = $this->findRequest($id);
        $labId = $request->lab_id;

        $testcategory = $this->listTestcategory($labId);

        $sampletype = [];
        $test = [];

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
                'testcategory'=>$testcategory,
                'sampletype'=>$sampletype,
            ]);
        }else{
            return $this->render('_form', [
                'model' => $model,
                'testcategory'=>$testcategory,
                'sampletype'=>$sampletype,
            ]);
        }
    }

    protected function findRequest($requestId)
    {
        if (($model = Request::findOne($requestId)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function listTestcategory($labId)
    {
        $testcategory = ArrayHelper::map(Testcategory::find()->andWhere(['lab_id'=>$labId])->all(), 'testcategory_id', 
           function($testcategory, $defaultValue) {
               return $testcategory->category_name;
        });

        /*$testcategory = ArrayHelper::map(Testcategory::find()
            ->where(['lab_id' => $labId])
            ->all(), 'testcategory_id', 'category_name');*/

        return $testcategory;
    }

    /**
     * Deletes an existing Test model.
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
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
