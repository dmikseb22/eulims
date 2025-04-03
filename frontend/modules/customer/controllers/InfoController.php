<?php

namespace frontend\modules\customer\controllers;

use Yii;
use common\models\lab\Customer;
use common\models\lab\CustomerSearch;
use common\models\address\Province;
use common\models\address\MunicipalityCity;
use common\models\address\Barangay;
use common\models\finance\CustomertransactionSearch;
use common\models\lab\RequestSearch;
use common\models\lab\Request;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use linslin\yii2\curl;
use yii\data\ActiveDataProvider;
/**
 * InfoController implements the CRUD actions for Customer model.
 */
class InfoController extends Controller
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
                    //'getprovince' => ['POST'],
                    'getmunicipality' => ['POST'],
                    'getbarangay' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionSync(){
        //fetch the customer pool
        // $customers = Customer::find()->all();

        foreach(Customer::find()->batch() as $customers) {
            // POST RAW JSON
            $curl = new Curl();

            $response = $curl->setRawPostData(
                 [
                    'data' => json::encode($customers),
                 ])
             ->post($GLOBALS['newapi_url']."sync_customer");

             echo $response;
        }
    }

    public function actionSyncrecord($id){

        $data = Customer::findOne($id);
        // $params = (array) $data;
        $params = [
            'email' => $data->email,
            'customer_id' => $data->customer_id,
            'rstl_id' => $data->rstl_id,
            'customer_name' =>$data->customer_name,
            'classification_id' =>$data->classification_id,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'head' => $data->head,
            'barangay_id' => $data->barangay_id,
            'address' => $data->address,
            'tel' => $data->tel,
            'fax' => $data->fax,
            'email' => $data->email,
            'customer_type_id' => $data->customer_type_id,
            'business_nature_id' => $data->business_nature_id,
            'industrytype_id' => $data->industrytype_id,
        ];
        try {
            $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
            $apiUrl=$GLOBALS['newapi_url']."message/synccustomer";

            $curl = new curl\Curl();
            $curl->setRequestBody(json_encode($params));
            $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
            $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
            $curl->setOption(CURLOPT_TIMEOUT, 180);
            $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
            $response = $curl->post($apiUrl);


            //  var_dump($response); exit;
            if($response==2){
                //update the record's 
                $data->sync_status = 2;
                $data->save();
                //notify user that the record may exist on the cloud server
                echo "User's email already exist proceed to confirmation";
             } elseif ($response) {
                //update the model with the customer code
                $data->sync_status = 1;
                $response = json_decode($response);
                // var_dump($response); exit();
                $data->customer_code=$response;
                $data->save();
                var_dump($data); exit();
                //user record sync
                echo "Customer Code Sync with ID: ".$response;
             }
             else{
                echo "Error : No response from API";
             }
            
        } catch (Exception $e) {
            echo "Syncing Failed...";
        }
       
    }

    public function actionConfirmrecord($id){


        $model = Customer::findOne($id);
        $curl = new curl\Curl();
        
        try {
            $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
            $curl->setOption(CURLOPT_TIMEOUT, 180);
            $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
            $response = $curl->setGetParams([
                'email' => $model->email,
             ])
             ->get($GLOBALS['newapi_url']."message/confirm");
            if ($curl->errorCode === null) {
               return $this->renderAjax('_view', [
                    'model' => $response,
                    'local'=>$model
                ]);
            }
            
        } catch (Exception $e) {
            echo "Curl Failed...";
        }
    }

    public function actionApplysync($code,$email){
        // echo $code; exit;
        if($code==null){
            $session = Yii::$app->session;
            $session->set('deletepopup',"Something Went Wrong!");
            return $this->redirect(['index']);
        }
        $model = Customer::find()->where(['email'=>$email])->one();
        $model->customer_code=$code;
        $model->sync_status=1;
        if($model->save()){
            $session = Yii::$app->session;
            $session->set('updatepopup',"executed");
        }else{
            $session = Yii::$app->session;
            $session->set('updatepopup',"Something Went Wrong!");
        }

        return $this->redirect(['index']);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $searchTransacModel = new CustomertransactionSearch();
        $transactions = $searchTransacModel->searchbycustomerid($id);

        $myreq = Request::find()->where(['customer_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $myreq,
        ]);

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
                'transactions'=>$transactions,
                'reqtransactions'=>$dataProvider
            ]);
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
                'transactions'=>$transactions,
                'reqtransactions'=>$dataProvider
            ]);
        }
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();
        $model->rstl_id=Yii::$app->user->identity->profile->rstl_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // $model->customer_code=$model->rstl_id."-".$model->customer_id;
            // $model->save();
            $session = Yii::$app->session;
            $session->set('savepopup',"executed");
            // return $this->redirect(['view', 'id' => $model->customer_id]);
            return $this->redirect(['index']);
        }

        if(Yii::$app->request->isAjax){
            $model->customer_type_id=2;
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // if(Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                 $session = Yii::$app->session;
                $session->set('savepopup',"executed");
               return $this->redirect(['index']);
            }   


            if(Yii::$app->request->isAjax){
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
            else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        // }
    }

    /**
     * Deletes an existing Customer model.
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

    public function actionGetprovince(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Province::find()->andWhere(['region_id'=>$id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $province) {
                    $out[] = ['id' => $province['province_id'], 'name' => $province['prov_desc']];
                    if ($i == 0) {
                        $selected = $province['province_id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);

    }

    public function actionGetmunicipality(){
         // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = MunicipalityCity::find()->andWhere(['province_id'=>$id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $city_municipality) {
                    $out[] = ['id' => $city_municipality['municipality_city_id'], 'name' => $city_municipality['citymun_desc']];
                    if ($i == 0) {
                        $selected = $city_municipality['municipality_city_id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    public function actionGetbarangay(){
         // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Barangay::find()->andWhere(['municipality_city_id'=>$id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $barangay) {
                    $out[] = ['id' => $barangay['barangay_id'], 'name' => $barangay['brgy_desc']];
                    if ($i == 0) {
                        $selected = $barangay['barangay_id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
