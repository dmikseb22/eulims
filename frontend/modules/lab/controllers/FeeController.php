<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Fee;
use common\models\lab\Request;
use common\models\lab\RequestSearch;
use common\models\lab\FeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Analysis;
use common\models\lab\Sample;
use common\models\lab\AnalysisSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\lab\Sampletype;
use common\models\lab\Testcategory;
use common\models\lab\Test;
use common\models\lab\SampleSearch;
use yii\helpers\Json;

/**
 * FeeController implements the CRUD actions for Fee model.
 */
class FeeController extends Controller
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
     * Lists all Fee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fee model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Fee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Fee();
        $searchModel = new FeeSearch();
        $request_id = $_GET['id'];
        $session = Yii::$app->session;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $samplesQuery = Sample::find()->where(['request_id' => $id]);
        $sampleDataProvider = new ActiveDataProvider([
                'query' => $samplesQuery,
                'pagination' => [
                    'pageSize' => false,
                           ],  
             
        ]);

        $request = $this->findRequest($request_id);
        $labId = $request->lab_id;
        //$testcategory = $this->listTestcategory($labId);
        $testcategory = [];
        $sampletype = [];
        $test = [];

        if ($model->load(Yii::$app->request->post())) {

            $sample_ids= $_POST['sample_ids'];
            $ids = explode(',', $sample_ids);  
            $post= Yii::$app->request->post();

            foreach ($ids as $sample_id){

                $analysis = new Analysis();
                $modelfee=  Fee::findOne(['fee_id'=>$post['Fee']['name']]);
                $analysis->sample_id = $sample_id;
                $analysis->cancelled = 0;
                $analysis->pstcanalysis_id = 1;
                $analysis->request_id = $request_id;
                $analysis->rstl_id = $GLOBALS['rstl_id'];
                $analysis->test_id = 1;
                $analysis->type_fee_id = 3;
                $analysis->user_id = 1;
                $analysis->sample_type_id = 1;
                $analysis->category_id = 1;
                $analysis->testcategory_id = 1;
                $analysis->is_package = 0;
                $analysis->method = "-";
                $analysis->fee = $post['Fee']['unit_cost'];
                $analysis->references = "-";
                $analysis->testname = $modelfee->name;
                $analysis->quantity = 1;
                $analysis->sample_code = "-";
                $analysis->date_analysis = '2018-06-14 7:35:0';   
                $analysis->save();
            }        
            
            Yii::$app->session->setFlash('success', 'Additional Fee Successfully Added');
            return $this->redirect(['/lab/request/view', 'id' =>$request_id]);
    } 
         if (Yii::$app->request->isAjax) {
                 $analysismodel = new Analysis();
                 $analysismodel->rstl_id = $GLOBALS['rstl_id'];
                 $analysismodel->pstcanalysis_id = $GLOBALS['rstl_id'];
                 $analysismodel->request_id = $GLOBALS['rstl_id'];
                 $analysismodel->testname = $GLOBALS['rstl_id'];
                 $analysismodel->cancelled = 0;
                 $analysismodel->sample_id = $GLOBALS['rstl_id'];
                 $analysismodel->sample_code = $GLOBALS['rstl_id'];
                 $analysismodel->date_analysis = '2018-06-14 7:35:0';
 
            return $this->renderAjax('_form', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'test' => $test,
                'sampletype'=>$sampletype
            ]);
        }else{
            return $this->render('_form', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'test' => $test,
                'sampletype'=>$sampletype
            ]);
        }
    }

    public function actionGetlistfee() {
        if(isset($_GET['fee_id'])){
            $id = (int) $_GET['fee_id'];
            $modelFee =  Fee::findOne(['fee_id'=>$id]);
            $unit_cost = $modelFee->unit_cost;
        } else {
            $unit_cost = "Error getting unit cost";
        }
        return Json::encode([
            'unit_cost'=>$unit_cost,
        ]);
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
        return $testcategory;
    }

    public function actionCreatepackage()
    {
        $model = new Packagelist();

        $searchModel = new PackageListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->analysis_id]);
        }
        
            $samplesQuery = Sample::find()->where(['request_id' => 1]);
            $sampleDataProvider = new ActiveDataProvider([
                    'query' => $samplesQuery,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                 
            ]);

            $testcategory = $this->listTestcategory(1);
         
            $sampletype = [];
            $test = [];

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'test' => $test,
                'sampletype'=>$sampletype
            ]);
        }else{
            return $this->render('_form', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Updates an existing Fee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->fee_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Fee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Fee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
