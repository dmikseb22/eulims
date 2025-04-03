<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Testnamemethod;
use common\models\lab\Methodreference;
use common\models\lab\Workflow;
use common\models\lab\ProcedureSearch;
use common\models\lab\Procedure;
use common\models\lab\TestnamemethodSearch;
use common\models\lab\Testname;
use common\models\lab\Lab;
use common\models\lab\Sampletype;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use linslin\yii2\curl;
use common\components\PstcComponent;
use common\models\system\LoginForm;
use yii\helpers\Html;


/**
 * TestnamemethodController implements the CRUD actions for Testnamemethod model.
 */
class TestnamemethodController extends Controller
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
     * Lists all Testnamemethod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestnamemethodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['testname_method_id' => SORT_DESC];
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetmethod()
	{
      
        $labid = $_GET['lab_id'];
        $testname_id = $_GET['id'];
    
        $methodreference = Methodreference::find()->orderBy(['method_reference_id' => SORT_DESC])->all();
        $testnamedataprovider = new ArrayDataProvider([
                 'allModels' => $methodreference,
                 'pagination' => [
                     'pageSize' =>false,
                 ],
              
         ]);
       

         return $this->renderAjax('_method', [
            'testnamedataprovider' => $testnamedataprovider,    
            'testname_id'=> $testname_id,
         ]);
	
     }

    public function actionWorkflow()
    {
        $searchModel = new TestnamemethodSearch();
        $model = new Testnamemethod();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexworkflow', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    public function actionWorkflows()
    {
        $searchModel = new TestnamemethodSearch();
        $model = new Testnamemethod();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexworkflow', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    public function actionIndextestnamemethod()
    {
        $searchModel = new TestnamemethodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['testname_method_id' => SORT_DESC];
        

        return $this->render('indextestname', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Testnamemethod model.
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

    public function actionCheckmethod($id)
    {
        if(isset($_SESSION['usertoken'])){
            $methodreference = Methodreference::find()->where(['method_reference_id' => $id])->one();
            
            $function = new PstcComponent();
            $response = $function->checkMethod($id);
            $lists = $function->listLab();
            $list = json_decode($lists);

            if(Yii::$app->request->isAjax){
                return $this->renderAjax('sync', [
                    'response' => $response,
                    'model' => $methodreference,
                    'laboratories' => $list->labs,
                    'sampletypes' => $list->sampletypes,
                    'testnamelist' => $list->testnamelist,
                ]);
            }
        }else{
            return Html::button('Please login to access the Synching thru API', ['value'=>'/chat/info/login', 'class' => 'btn btn-lg btn-info','title' => Yii::t('app', "Login"),'id'=>'btnOP','onclick'=>'LoadModal(this.title, this.value,"100px","300px");']);
        }
    }

    public function actionSyncmethod()
    {
        if(isset($_SESSION['usertoken'])){
        $id = Yii::$app->request->post('id');
        $methodreference = Methodreference::find()->where(['method_reference_id' => $id])->one();
        
        $params = [
            'sync_id' => Yii::$app->user->identity->profile->rstl_id.'-'.$methodreference->method_reference_id,
            'method' => $methodreference->method,
            'reference' =>$methodreference->reference,
            'fee' => $methodreference->fee,
            'testname_id' => Yii::$app->request->post('testname_id'),
            'sampletype_id' => Yii::$app->request->post('sampletype_id'),
            'lab_id' => Yii::$app->request->post('lab_id')
        ];

        $function = new PstcComponent();
        $response = $function->syncMethod($params);
        return $response;
    }else{
        $model = new LoginForm();
        return $this->render('login', [
        'model' => $model
        ]);
    }
    }



    
    /**
     * Creates a new Testnamemethod model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     
      Created By: Bergel T. Cutara
      Contacts:

      Email: b.cutara@gmail.com
      Tel. Phone: (062) 991-1024
      Mobile Phone: (639) 956200353

      Description: Action Create should cater all the needs to manage the lab, sampletype, testname and methods, all queries should go here.

     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Testnamemethod();
        $testnamelist= ArrayHelper::map(Testname::find()->orderBy(['testname_id' => SORT_DESC])->all(),'testname_id','testName');
        $labs = ArrayHelper::map(Lab::find()->all(),'lab_id','labname');
        $sampletypes = ArrayHelper::map(Sampletype::find()->where(['status_id'=>1])->all(),'sampletype_id','type');

        if ($model->load(Yii::$app->request->post())) {
          $model->save();
          return $this->redirect(['index']);
        }

        if(Yii::$app->request->isAjax){
            $model->create_time=date("Y-m-d h:i:s");
            $model->update_time=date("Y-m-d h:i:s");
            return $this->renderAjax('_form', [
              'model' => $model,
              'testnamelist' => $testnamelist,
              'labs' => $labs,
              'sampletypes'=>$sampletypes,
            ]);
       }
    }

    public function actionCreateworkflow()
    {
        $id = $_GET['test_id'];
        $testname_id = $id;
        $searchModel = new ProcedureSearch();
        $model = new Procedure();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $workflow = Workflow::find()->where(['testname_method_id' => $id]);

        $workflowdataprovider = new ActiveDataProvider([
                'query' => $workflow,
                'pagination' => [
                    'pageSize' => false,
                ],
             
        ]);

        return $this->renderAjax('_createworkflow', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'workflowdataprovider'=>$workflowdataprovider,
            'testname_id'=>$testname_id,
            'model'=>$model,
        ]);
    }

    public function actionAddworkflow()
    {
        $id = $_POST['id'];
        $testname_id = $_POST['testname_id'];
        $searchModel = new ProcedureSearch();
        $model = new Procedure();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $Connection= Yii::$app->labdb;
        $sql="UPDATE `tbl_testname_method` SET `workflow`=1 WHERE `testname_method_id`=".$testname_id;
        $Command=$Connection->createCommand($sql);
        $Command->execute();  

        $procedure = Procedure::find()->where(['procedure_id' => $id])->one();       
        $workflow = new Workflow();
        $workflow->testname_method_id = $testname_id;
        $workflow->method_id = $id;
        $workflow->procedure_name = $procedure->procedure_name;
        $workflow->status = 1;
        $workflow->save();

        $workflow = Workflow::find()->where(['testname_method_id' => $testname_id]);
        
                $workflowdataprovider = new ActiveDataProvider([
                        'query' => $workflow,
                        'pagination' => [
                            'pageSize' => false,
                        ],
                     
                ]);

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_workflow', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'workflowdataprovider'=>$workflowdataprovider,
                'testname_id'=>$testname_id,
                'model'=>$model,
            ]);
        }
    
        
   }

   public function actionAddprocedure()
   {
       $procedure_name = $_POST['procedure_name'];
       $testname_id = $_POST['testname_id'];
       $searchModel = new ProcedureSearch();
       $model = new Procedure();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      // $procedure = Procedure::find()->where(['procedure_id' => $id])->one();
  
       $procedure = new Procedure();
       $procedure->procedure_name = $procedure_name;
       $procedure->procedure_code = "1";
       $procedure->testname_id = "1";
       $procedure->testname_method_id = "1";
       $procedure->save();

       $workflow = Workflow::find()->where(['testname_method_id' => $testname_id]);
       
               $workflowdataprovider = new ActiveDataProvider([
                       'query' => $workflow,
                       'pagination' => [
                           'pageSize' => false,
                       ],
                    
               ]);

       if(Yii::$app->request->isAjax){
           return $this->renderAjax('_workflow', [
               'searchModel' => $searchModel,
               'dataProvider' => $dataProvider,
               'workflowdataprovider'=>$workflowdataprovider,
               'testname_id'=>$testname_id,
               'model'=>$model,
           ]);
       }
   
       
  }

  public function actionAddtemplate()
  {
      //$testnamemethod_id = $_POST['testnamemethod_id'];
      $testnamemethod_id = 1;
      $testname_id = $_POST['testname_id']; //testnamemethod_id po ito hihi
      $searchModel = new ProcedureSearch();
      $model = new Procedure();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      
      $workflow = Workflow::find()->where(['testname_method_id' => $testnamemethod_id])->all();
      
      $sample_ids = '';
      foreach ($workflow as $sample){
          $sample_ids .= $sample->workflow_id.",";
      }
      $sample_ids = substr($sample_ids, 0, strlen($sample_ids)-1);
     
   
    $ids = explode(",", $sample_ids);   
    

    foreach ($ids as $workflow){  
        $workflows = Workflow::find()->where(['workflow_id' => $workflow])->one();

        $procedure = Procedure::find()->where(['procedure_id' => $workflows->method_id])->one();       
        $workflow = new Workflow();
        $workflow->testname_method_id = $testname_id;
        $workflow->method_id = $workflows->method_id; //procedure_id
        $workflow->procedure_name = $procedure->procedure_name;
        $workflow->status = 1;
        $workflow->save();
    }

    

      $workflow = Workflow::find()->where(['testname_method_id' => $testname_id]);
      
              $workflowdataprovider = new ActiveDataProvider([
                      'query' => $workflow,
                      'pagination' => [
                          'pageSize' => false,
                      ],
                   
              ]);

      if(Yii::$app->request->isAjax){
          return $this->renderAjax('_workflow', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
              'workflowdataprovider'=>$workflowdataprovider,
              'testname_id'=>$testname_id,
              'model'=>$model,
          ]);
      }
  
      
 }

   public function actionDeleteworkflow()
   {
       $id = $_POST['id'];
       $testname_id = $_POST['testname_id'];
       $searchModel = new ProcedureSearch();
       $model = new Procedure();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


       $procedure = Procedure::find()->where(['procedure_id' => $id])->one();

       

      $workflow = Workflow::find()->where(['testname_method_id' => $testname_id]);

       $Connection= Yii::$app->labdb;
       $sql=" DELETE FROM `tbl_workflow` WHERE `workflow_id`=".$id;
       $Command=$Connection->createCommand($sql);
       $Command->execute();    

               $workflowdataprovider = new ActiveDataProvider([
                       'query' => $workflow,
                       'pagination' => [
                           'pageSize' => false,
                       ],
                    
               ]);

       if(Yii::$app->request->isAjax){
           return $this->renderAjax('_workflow', [
               'searchModel' => $searchModel,
               'dataProvider' => $dataProvider,
               'workflowdataprovider'=>$workflowdataprovider,
               'testname_id'=>$testname_id,
               'model'=>$model,
           ]);
       }
     //  $services_model = Services::find()->where(['services_id' => $services->services_id])->one();
       
  }


    /**
     * Updates an existing Testnamemethod model.
     * If update is successful, the browser will be redirected to the 'index' page.
      Created By: Bergel T. Cutara
      Contacts:

      Email: b.cutara@gmail.com
      Tel. Phone: (062) 991-1024
      Mobile Phone: (639) 956200353

      Description: all queries should go here.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $testnamelist= ArrayHelper::map(Testname::find()->orderBy(['testname_id' => SORT_DESC])->all(),'testname_id','testName');
        $labs = ArrayHelper::map(Lab::find()->all(),'lab_id','labname');
        $sampletypes = ArrayHelper::map(Sampletype::find()->where(['status_id'=>1])->all(),'sampletype_id','type');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);

        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
                'testnamelist' => $testnamelist,
                'labs' => $labs,
                'sampletypes'=>$sampletypes,
            ]);
         }
    }

    /**
     * Deletes an existing Testnamemethod model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
        if($model->delete()) {            
          //  Yii::$app->session->setFlash('success', 'Test Name Method Successfully Deleted'); 
            return $this->redirect(['index']);
        } else {
            return $model->error();
        }
    }

    /**
     * Finds the Testnamemethod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testnamemethod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testnamemethod::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
