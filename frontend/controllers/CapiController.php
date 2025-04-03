<?php



namespace app\controllers;


use Yii;

use yii\web\Response;

use yii\rest\ActiveController;

use yii\data\ActiveDataProvider;



class ApiController extends ActiveController

{

    public $modelClass = 'app\models\OrderOfPayment';

    public $modelClass1 = 'app\models\PaymentDetails';

    public function behaviors()
    {
	return [
	    [
	        'class' => 'yii\filters\ContentNegotiator',
	        'only' => ['view', 'index'],
	        'formats' => [
	                'application/json' => Response::FORMAT_JSON,
	        ],
	    ],
            [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 86400,
                ]    
            ],
	];
    }

    public function actionOp()
    {

      $model = new $this->modelClass;

      if(isset($_GET['id'])){
      	$data = $model::find()->where(["op_id" => $_GET['id']])->all();
      }
      else if ($model->load(Yii::$app->request->post(), '')) {
	$req_id = 0;

	// req_data retrieves the posted json data
	$req_data = Yii::$app->request->post();

	// payment_details gets the payment details from posted the json data
	$payment_details = $req_data['payment_details'];
        // start transaction
        $Connection= Yii::$app->epayment_db;
        $Transaction =$Connection->beginTransaction();
	// Save in the tbl_order_of_payment
        $model->transaction_num = $req_data['transaction_num'];
        $model->customer_code = $req_data['customer_code'];
        $model->collection_type = $req_data['collection_type'];
        $model->collection_code = $req_data['collection_code'];
        $model->order_date = $req_data['order_date'];
        $model->agency_code = $req_data['agency_code'];
        $model->total_amount = $req_data['total_amount'];
        $model->op_status = 'Pending';
        $success=$model->save();

	// Get the op_id of the stored order of payment data
	$req_id = $model->op_id;
        $successItem=false;
        if($success){
	// Loop (if there is) and save the payment details 
            for($i = 0; $i < count($payment_details); $i++){

                $model1 = new $this->modelClass1;

                // Save in the tbl_payment_details
                $model1->op_id = $req_id;
                $model1->request_ref_num = $payment_details[$i]['request_ref_num'];
                $model1->rrn_date_time = $payment_details[$i]['rrn_date_time'];
                $model1->amount = $payment_details[$i]['amount'];

                if($model1->validate()){
                    $successItem=$model1->save();
                    unset($model1);
                }
                else{
                    $successItem=false;
                }
            }
            // Check
            if($successItem){
                $Transaction->commit();
                // If the data stored successfully
                $data=[
                   'status'=>'success',
                   'description'=>'OP Successfuly Posted.'
                ];
            }else{
                $Transaction->rollback();
                // If there is an error saving the data
                $errors = $model1->errors;
                $data=[
                   'status'=>'error',
                   'description'=>'Failed to save details, Please check the data.'
                ];
            }
        }else{//Error saving OP
            $Transaction->rollback();
            $errors = $model->errors;
            $data=[
                'status'=>'error',
                'description'=>'Saving OP Failed, OP might already been posted.'
            ];
        }
      }else{
      	$data=[
            'status'=>'error',
            'description'=>'Please check your data'
        ];
      }

      Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
      return $data;

    }

}