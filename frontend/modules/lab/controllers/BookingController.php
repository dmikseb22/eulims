<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Booking;
use common\models\lab\BookingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\inventory\components\_class\Schedule;
use common\models\lab\Customer;
use yii\db\Query;
use common\models\lab\Sampletype;
use yii\helpers\ArrayHelper;
use common\models\lab\Testnamemethod;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use frontend\modules\lab\components\eRequest;
use common\models\system\Profile;
use common\models\lab\Sample;
use common\models\lab\CustomerBooking;
use common\models\lab\Trackform;
use common\models\lab\Bookingrequest;
/**
 * BookingController implements the CRUD actions for Booking model.
 */
class BookingController extends Controller
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
     * Lists all Booking models.
     * @return mixed
     */
    public function actionIndex()
    {
      $session = Yii::$app->session;
      $session->set('hideMenu',true);
      if(!Yii::$app->user->isGuest){
        $searchModel = new BookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
      }
        else{
          return $this->render('indexcustomer');
        }
    }

    /**
     * Displays a single Booking model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model=$this->findModel($id);
		
		$customer_id= $model->customer_id;
		if($model->customerstat == 1){
			$customer =Customer::findOne($customer_id);
		}
		else{
			$customer =CustomerBooking::findOne($customer_id);
		}
		//$customer =CustomerBooking::find()->where(['customer_booking_id'=>$model->customer_id])->one();
        return $this->render('view', [
            'model' => $model,
			'customer' => $customer
        ]);
    }


     public function actionViewbyreference()
    {
      $trackform = new Trackform();

      if ($trackform->load(Yii::$app->request->post())) {

          $booking = Booking::find()->where(['booking_reference'=>$trackform->referencenumber])->one();
          if($booking){
            return $this->redirect(['viewcustomer', 
                'id' => $booking->booking_id,
            ]);
          }
          else{
            Yii::$app->session->setFlash('error','Reference Number Not Found!');
             return $this->redirect('index');
          }
      }

        return $this->renderAjax('viewbyreference', [
          'model'=> $trackform
        ]);
    }
	

    /**
     * Creates a new Booking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		
        $model = new Booking();
    		$customer = new CustomerBooking();
    		$testname = [];
       // $model->rstl_id=11; //default 11, just get all from the db, let the db set the defualt rstlid to 11
        if ($model->load(Yii::$app->request->post()) && $customer->load(Yii::$app->request->post())) {
            $customer->save(false);
            $model->modeofrelease_ids=1;//pickup
			      $model->booking_status=0; //status pending
            $model->date_created=date("Y-m-d");
            if(isset($_POST['qty_sample'])){
                $quantity = (int) $_POST['qty_sample'];
            } else {
                $quantity = 1;
            }
            $model->qty_sample=$quantity;
            $model->customer_id=$customer->customer_booking_id;
            $model->sampletype_id;
      			$model->description;
      			$model->modeofrelease_ids='1';
			
			
            if($model->save()){
              Yii::$app->session->setFlash('success','Successfully Saved, Reference Number : '.$model->booking_reference);

                 return $this->redirect(['viewcustomer', 
                  'id' => $model->booking_id,
              ]);
            }else{
              return $this->redirect(['index']);
            }
			
            

        }
        
        return $this->renderAjax(
		    'create', [
            'model' => $model,
      			'sampletype'=>$this->listSampletype(),
      			'testname'=>$testname,
      			'customer'=>$customer
        ]);
    }

    public function actionViewcustomer($id){
      return $this->render('viewcustomer', [
              'model' =>$this->findModel($id),
          ]);
    }
    
    public function actionJsoncalendar($start=NULL,$end=NULL,$_=NULL,$id){

    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $events = array();
    
    //as of now get all the schedules
    $schedules = Booking::find()->where(['booking_status'=>0])->all(); 
	
    foreach ($schedules AS $schedule){
        $customer_id= $schedule->customer_id;
		if($schedule->customerstat==1){
			$customer =Customer::findOne($customer_id);
		}
		else{
			$customer =CustomerBooking::findOne($customer_id);
		}
        $Event= new Schedule();
        $Event->id = $schedule->booking_id;
        $Event->title =$customer->customer_name.": ".$schedule->description."\n Sample Qty:".$schedule->qty_sample;
        $Event->start =$schedule->scheduled_date;

        $date = $schedule->scheduled_date;
        $date1 = str_replace('-', '/', $date);
        $newdate = date('Y-m-d',strtotime($date1 . "+1 days"));
        $Event->end  = $newdate;
        $events[] = $Event;
    }

    return $events;
  }

    /**
     * Updates an existing Booking model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','Successfully Updated');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Booking model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success','Successfully Removed!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Booking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Booking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Booking::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	 protected function findModelcustomer($id)
    {
        if (($model = CustomerBooking::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     
     public function actionManage()
     {
        $model = new Booking();
        $searchModel = new BookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;
        return $this->render('manage', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
         
     }
	 
	 protected function listSampletype()
    {
        $sampletype = ArrayHelper::map(Sampletype::find()->andWhere(['status_id'=>1])->all(), 'sampletype_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->type;
        });

        return $sampletype;
    }
	
	 public function actionListsampletype() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            //$sampleids = end($_POST['depdrop_parents']);
            $sampletypeId = end($_POST['depdrop_parents']);
			$list = Testnamemethod::find()->with('testname')->where(['sampletype_id'=>$sampletypeId])->asArray()->all();

            $selected  = null;
            if ($sampletypeId != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i) {
                    if($i['testname']){
                        $out[] = ['id' => $i['testname']['testname_id'], 'name' => $i['testname']['testName']];
                        if ($i == 0) {
                            $selected = $testname['testname_id'];
                        }
                    }
                }
                \Yii::$app->response->data = Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }
	 public function actionGettestnamemethod()
	{
      
        $testname_id = $_GET['testname_id'];
        $sampletype_id = $_GET['sampletype_id'];
    


        $testnamemethod = Testnamemethod::find()
        ->where(['tbl_testname_method.testname_id'=>$testname_id,'tbl_testname_method.sampletype_id'=>$sampletype_id])->all();

        
        $testnamedataprovider = new ArrayDataProvider([
                'allModels' => $testnamemethod,
                'pagination' => [
                    'pageSize' => false,
                ],
             
        ]);
   
        return $this->renderAjax('_method', [
           'testnamedataprovider' => $testnamedataprovider,
        ]);
	
     }
	 
	 public function actionSaverequest($id)
    {
        $model = $this->findModel($id);
		
		$request = new eRequest();
		
		//return $this->redirect(['view', 'id' => $model->request_id]);
		$profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
		$request->request_datetime=date("Y-m-d H:i:s");
		//$model->report_due=date_format($date2,"Y-m-d");
		$request->created_at=date('U');
		$request->rstl_id= Yii::$app->user->identity->profile->rstl_id;//$GLOBALS['rstl_id'];
		$request->payment_type_id=1;
		$request->modeofrelease_ids='1';
		$request->discount_id=0;
		$request->discount='0.00';
		$request->total=0.00;
		$request->posted=0;
		$request->status_id=1;
	   // $model->contact_num="123456789";
		$request->request_type_id=1;
		$request->modeofreleaseids='1';
		$request->payment_status_id=1;
	   // $model->request_type_id=1;
		$request->request_date=date("Y-m-d");
		if($profile){
			$request->receivedBy=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
		}else{
			$request->receivedBy="";
		}
		$request->lab_id=1;
		$request->customer_id=$model->customer_id;
		$request->conforme="";
		$request->booking_id=$model->booking_id;
		$request->purpose_id=$model->purpose;
		$request->report_due=date("Y-m-d");

		$request->save(false);
		$quantity=$model->qty_sample;
	    if($quantity > 1)
		{
			for ($i=1;$i<=$quantity;$i++)
			{
				$sample = new Sample();
				$sample->rstl_id=$model->rstl_id;
				$sample->sampletype_id = $model->sampletype_id;
				$sample->samplename = $model->samplename;
				$sample->description = "";
				$sample->customer_description = $model->description;
				$sample->request_id = $request->request_id;
				if($request->request_type_id == 2){
					$sample->sample_month = date('n',($request->created_at));
					$sample->sample_year = date('Y',($request->created_at));
				} else {
					$sample->sample_month = date('m', strtotime($request->request_datetime));
					$sample->sample_year = date('Y', strtotime($request->request_datetime));
				}
				$sample->save(false);
			}
		}
		
		
		$bookingrequest = new Bookingrequest();
		$bookingrequest->request_id= $request->request_id;
		$bookingrequest->booking_id= $id;
		$bookingrequest->save();
		$model->booking_status=1; //Status Approved
		$model->save(false);
		return $this->redirect(['/lab/request/view', 'id' => $request->request_id]);
		//Yii::$app->session->setFlash('success', 'Successfully Created!');
      
		
		//return $this->redirect(['index']);
    }
	
	 public function actionSavecustomer($id)
    {
        $model = $this->findModel($id);
		$customerid= $model->customer_id;
		$customermodel=$this->findModelcustomer($customerid);
		$customermodel->status=1;
		$customermodel->save();
		
		$customer = new Customer();
		$customer->rstl_id= 11; //default
		$customer->customer_name= $customermodel->customer_name;
		$customer->classification_id= $customermodel->classification_id;
		$customer->address= $customermodel->address;
		$customer->tel= $customermodel->tel;
		$customer->email= $customermodel->email;
		$customer->business_nature_id= $customermodel->business_nature_id;
		$customer->save(false);
		$model->customer_id=$customer->customer_id;
		$model->customerstat=1; //Customer updated
		$model->save(false);
		Yii::$app->session->setFlash('success','Customer Updated!');
		return $this->redirect(['/lab/booking/view', 'id' => $id]);
	}	
	 public function actionCancelbooking($id)
    {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			$model->booking_status=2;//cancelled
			$model->save(false);
		}
		else{
			return $this->renderAjax('cancel', [
            'model' => $model,
			]);
		}
		Yii::$app->session->setFlash('success','Cancelled!');
		return $this->redirect(['/lab/booking/view', 'id' => $id]);
		
	}
	 public function actionExistingcustomer($id)
    {
		$model = $this->findModel($id);
		$customer=ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name');
		if ($model->load(Yii::$app->request->post())) {
			//echo $model->customer_id;
			//exit;
			$model->customerstat=1; //Customer updated
			$model->save(false);
		}
		else{
			return $this->renderAjax('existingcustomer', [
            'model' => $model,
			'customers' => $customer
			]);
		}
		Yii::$app->session->setFlash('success','Customer Updated!');
		return $this->redirect(['/lab/booking/view', 'id' => $id]);
	}
	
	public function actionRequestview($id){
		$request=eRequest::find()->where(['booking_id'=>$id])->one();
		if($request){
			$requestid=$request->request_id;
			return $this->redirect(['/lab/request/view', 'id' => $requestid]); 
		}else{
			return;
		}
		
	}
}
