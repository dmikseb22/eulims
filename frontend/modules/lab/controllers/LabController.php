<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Lab;
use common\models\lab\LabSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LabController implements the CRUD actions for Lab model.
 */
class LabController extends Controller
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
     * Lists all Lab models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LabSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lab model.
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
     * Creates a new Lab model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lab();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->lab_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lab model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->lab_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Lab model.
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
     * Finds the Lab model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lab the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lab::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}


////////////////////////////////

// public function actionSynccustomer($start,$url = "http://ulimsportal.onelab.ph/api/sync_customer"){
//     // public function actionSynccustomer($start,$url = "http://www.eulims.local/api/sync_customer"){
//      //get all the customers
//      $customers= Yii::app()->db->createCommand("SELECT * FROM ulimslab.customer ORDER BY id ASC LIMIT ".$start.",500")->queryAll();
//      // $customers = Customer::model()->findAll(); 
//      // var_dump($customers); exit;
//      $allCustomers = [];
//      foreach($customers as $customer){
//       // var_dump($customer); 
//       $temp = [
//        'customerName' => $customer['customerName'],
//        'rstl_id'=> $customer['rstl_id'],
//                    'classification_id'=> 1,
//                    'latitude'=> "",
//                    'longitude'=> "",
//                    'head'=> $customer['head']? $customer['head']:"N/A",
//                    'barangay_id'=> $customer['barangay_id'],
//                    'address'=> $customer['address']?$customer['address']:"NA",
//                    'tel'=> $customer['tel']?$customer['tel']:"NA",
//                    'fax'=> $customer['fax']?$customer['fax']:"NA",
//                    'email'=> $customer['email']?$customer['email']:"NA",
//                    'typeId'=> $customer['typeId'],
//                    'natureId'=> $customer['natureId'],
//                    'industryId'=> $customer['industryId'],
//                    'created'=> $customer['created'],
//                    'id'=> $customer['id'],
//                    'municipalitycity_id'=> $customer['municipalitycity_id'],
//                    'district'=> $customer['district'],
//       ];
//       array_push($allCustomers, $temp);
//      }
   
//      $response = Yii::app()->curl->post($url, ['data'=>json_encode($allCustomers)]);
   
//      $response=json_decode($response);
   
//      if($response){
//       $table = "customer";
//       $num = $response->num;
//       $ids = $response->ids;
//       //parse the json file here
   
//       $yiimig = Yiimigration::model()->findByattributes(['tblname'=>$table]);
      
//       if($yiimig){
//        $yiimig->num = $yiimig->num + $num;
//        $yiimig->ids = $yiimig->ids.$ids;
//        $yiimig->save();
//       }
//      }
     
//      $this->redirect(array(
//       'index'

//       /////////////////////////
