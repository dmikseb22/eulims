<?php

namespace console\controllers;

use Yii;
use common\models\api\Syncapi;
use \yii\console\Controller;
use fedemotta\cronjob\models\CronJob;
use PhpOffice\PhpSpreadsheet\Shared\Date;
//use frontend\modules\api\controllers\SchedsyncController;

use common\models\system\User;
use common\models\system\Profile;
use yii\web\Session;

use common\models\finance\Customerwallet;
use common\models\finance\Customertransaction;
use common\models\lab\Booking;
use common\models\lab\Customeraccount;
use common\models\lab\Purpose;
use common\models\lab\Modeofrelease;
use common\models\lab\Request;
use common\models\lab\Sampletype;
use common\models\lab\Customer;
use common\models\lab\Sample;
use common\models\lab\Loginlogs;
use phpDocumentor\Reflection\Types\Null_;
use Datetime;
use yii\base\ErrorException;

class SchedsyncController extends Controller
{
    public $rstl_id;
    public $fullname;
  //  public $mainurl ='https://eulims.onelab.ph/';
    public function actionIndex()
    {
          $test =  Profile::find()->one();
     // echo $test['rstl_id'];
     //   echo "Cron Service Running";
    }

    public function actionCrontest()
    {
      //  SchedsyncController::Savesyncsample(1158);
    }

    public function actionSqlquery()
    {
        $rec = Booking::find()->one();
        if ($rec) {
           $sql="";
            $data_sync = array(
                'rstl_id'=>$rec->rstl_id,
            //  'booking_id'=>$booking->booking_id,
                'scheduled_date'=>$rec->scheduled_date,
                'booking_reference'=>$rec->booking_reference,
                'description'=>$rec->description,
                'date_created'=>$rec->date_created,
                'booking_status'=>$rec->booking_status,
                'modeofrelease_ids'=>$rec->modeofrelease_ids,
                'samplename'=>$rec->samplename,
                'sampletype_id'=>$rec->sampletype_id,
                'reason'=>$rec->reason,
                'customerstat'=>$rec->customerstat,
                'purpose'=>$rec->purpose,
                'qty_sample'=>$rec->qty_sample,
                'customer_id'=>$rec->customer_id,
                'sync_by'=>'',//Yii::$app->user->identity->profile->fullname,
                'sync_date'=> date('Y-m-d H:i:s'),
                'local_booking_id'=>$rec->booking_id);
            // 'xxx'=>Yii::$app->user->identity->profile->fullname,

            $sql = "insert into tbl_booking (
                `rstl_id`,`scheduled_date`,`booking_reference`,`description`,`date_created`,
                `booking_status`,`modeofrelease_ids`,`samplename`, `sampletype_id`,`reason`,`customerstat`,   
               `purpose`,`qty_sample`,`customer_id`,`sync_by`,`sync_date`,`local_booking_id`)  VALUES(" .
               $rec->rstl_id . ",'" . $rec->scheduled_date . "','" . $rec->booking_reference . "','" . $rec->description . "','" . $rec->date_created . "',"
               . $rec->booking_status . ",'" . $rec->modeofrelease_ids . "','" . $rec->samplename . "'," . $rec->sampletype_id . ",'". $rec->reason . "'," . $rec->customerstat . ",'"
               . $rec->purpose . "'," . $rec->qty_sample . "," . $rec->customer_id . "," . "'MARIANO','" . date('Y-m-d H:i:s') . "'," . $rec->booking_id . ")";
       
               Yii::$app->labdb->createCommand($sql)->execute();
             
        echo $sql;
        }
    }

    public function actionCronprofile()
    {
        try {
            $loginlogs = Loginlogs::find()->orderBy(['login_date'=>SORT_DESC])->one();
            $userid = $loginlogs['user_id'];
            //   ['user_id'=>$loginlogs['user_id']
            $user = User::find()->where(['user_id'=>$userid])->one();
            $profile = Profile::find()->where(['user_id'=>$userid])->one();

            if ($user) {
                $user_data = array(
                'username' => $user->username,
                'auth_key' => $user->auth_key,
                'password_hash'=>$user->password_hash,
                'email'=>$user->email,
                'user_id'=> $userid,
                'lastname'=>$profile->lastname,
                'firstname'=>$profile->firstname,
                'designation'=>$profile->designation,
                'middleinitial'=>$profile->middleinitial,
                'rstl_id'=> $profile->rstl_id,
                'lab_id'=>$profile->lab_id,
                'contact_numbers'=>$profile->contact_numbers,
                
                //'rememberMe'=>true,
        
              );

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_POST, 1);
                  
               curl_setopt($curl, CURLOPT_URL, 'https://eulims.onelab.ph/api/sync/passlogin');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_PROXY, ''); //!! FIX
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($curl);
           
                curl_close($curl);
            }
        }
        catch(ErrorException $e)
        {
           // echo $e;
            //echo "Exception caught";
            SchedsyncController::sendemailerror('cronprofile',$profile->rstl_id,$e);
            exit();
            
        }

        
      

        //  $reqtoken =  json_decode($result, true); 
        //        var_dump($result);
    }

    public function actionCroncustomer()
    {
        try{
            $loginlogs = Loginlogs::find()->orderBy(['login_date'=>SORT_DESC])->one();
            $userid = $loginlogs['user_id'];
            $user = User::find()->where(['user_id'=>$userid])->one();
            $profile = Profile::find()->where(['user_id'=>$userid])->one();
            // $test =  Profile::find()->one();
            $rstlid = $profile['rstl_id'];
            $fullname = $profile['firstname'] . " " . $profile['lastname'] . "- RSTL ID : " . $profile['rstl_id'];
            $curl = curl_init();
            $user_data = array('email'=>$user['email']);
            curl_setopt($curl, CURLOPT_POST, 1);

            // echo $user['email'];
    
            curl_setopt($curl, CURLOPT_URL, 'https://eulims.onelab.ph/api/sync/verifylogin');

            // Make it so the data coming back is put into a string
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_PROXY, ''); //!! FIX
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
            $result = curl_exec($curl);
            $reqtoken = array();
            $reqtoken =  json_decode($result, true);
        
            // foreach ($reqtoken as $rec)
            // {
            //     $reqtoken = $rec['token'][0];
            // }
        
            $result = curl_exec($curl);
            $reqtoken = array();
            $reqtoken =  json_decode($result, true);

            $session = new Session;
            $session['sessiontoken'] = $reqtoken['token'];
 
            $generatedtoken = $reqtoken['token'];
            if($generatedtoken == '')
            {
                SchedsyncController::sendemailerror('croncustomer',$profile->rstl_id,'Token not generated');
                exit();
            }

          $customerstatus = SchedsyncController::Savesynccustomer($rstlid, $fullname);
        }
        catch(ErrorException $e)
        {
           // echo $e;
            //echo "Exception caught";
            SchedsyncController::sendemailerror('croncustomer',$profile->rstl_id,$e);
            exit();
        }

    }

    public function actionCronsyncbycustomer()
    {

        try {
            
            $loginlogs = Loginlogs::find()->orderBy(['login_date'=>SORT_DESC])->one();
            $userid = $loginlogs['user_id'];
            $user = User::find()->where(['user_id'=>$userid])->one();
            $profile = Profile::find()->where(['user_id'=>$userid])->one();
            // $test =  Profile::find()->one();
            $rstlid = $profile['rstl_id'];
            $fullname = $profile['firstname'] . " " . $profile['lastname'] . "- RSTL ID : " . $profile['rstl_id'];
            $curl = curl_init();
            $user_data = array('email'=>$user['email']);
            curl_setopt($curl, CURLOPT_POST, 1);

            // echo $user['email'];
    
            curl_setopt($curl, CURLOPT_URL, 'https://eulims.onelab.ph/api/sync/verifylogin');

            // Make it so the data coming back is put into a string
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_PROXY, ''); //!! FIX
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
            $result = curl_exec($curl);
            $reqtoken = array();
            $reqtoken =  json_decode($result, true);
        
            // foreach ($reqtoken as $rec)
            // {
            //     $reqtoken = $rec['token'][0];
            // }
        
            $result = curl_exec($curl);
            $reqtoken = array();
            $reqtoken =  json_decode($result, true);

            $session = new Session;
            $session['sessiontoken'] = $reqtoken['token'];
 
            $generatedtoken = $reqtoken['token'];
            if($generatedtoken == '')
            {
                SchedsyncController::sendemailerror('cronsyncbycustomer',$profile->rstl_id,'Token not generated');
                exit();
            }

          //$customerstatus = SchedsyncController::Savesynccustomer($rstlid, $fullname);
           
          //  if ($customerstatus == 'done') 
          //  {
            //    echo 'Customer Syncing done.' . "\n\r";

                $api_param = array(
            'rstl_id'=>$rstlid);
            
        
                $customer_list =   SchedsyncController::callrestapireturn('POST', 'https://eulims.onelab.ph/api/sync/synccustacct', $api_param);
                $reqstatus='';
                $samstatus='';
                $samtypestatus='';
                $bookingstatus='';
                $walletstatus='';
              
             //  echo  count( $customer_list);
            
                foreach ($customer_list as $rec) {
                  echo   $rec['customer_id'];
                   $reqstatus = SchedsyncController::Savesyncrequest($rec['customer_id'], $rstlid, $fullname);
                    if ($reqstatus == 'done') 
                    {
                        echo 'Request Syncing done.' . "\n\r";
                        $samstatus = SchedsyncController::Savesyncsample($rec['customer_id'], $rstlid, $fullname);

                        if ($samstatus=='done') 
                        {
                            echo 'Sample Syncing done.' . "\n\r";
                            $samtypestatus = SchedsyncController::Savesyncsampletype($rec['customer_id'], $rstlid, $fullname);

                            if ($samtypestatus=='done') 
                            {
                                echo 'SampleType Syncing done.' . "\n\r";
                                $bookingstatus = SchedsyncController::Savesyncbooking($rec['customer_id'], $rstlid, $fullname);
                                if ($bookingstatus == 'done') 
                                {
                                    echo 'Booking Syncing done.' . "\n\r";
                                    $walletstatus = SchedsyncController::Savesynccustwallet($rec['customer_id'], $rstlid, $fullname);
                                    if ($walletstatus == 'done') 
                                    {
                                        echo 'Customerwallet Syncing done.' . "\n\r";
                                        SchedsyncController::Savesynccusttrans($rec['customer_id'], $rstlid, $fullname);
                                    }
                                }
                            }
                        }
                    }
                }
          //  }
        }
        catch(ErrorException $e)
        {
           // echo $e;
            //echo "Exception caught";
            SchedsyncController::sendemailerror('cronsyncbycustomer',$profile->rstl_id,$e);
            exit();
        }

   

    }

    public function actionCronbookinglocal()
    {
        // $test =  Profile::find()->one();
        // $curl = curl_init();
        // $user_data = array( 'email'=>'bernadettebucoybelamide@gmail.com');
        // curl_setopt($curl, CURLOPT_POST, 1);
    try{
        $loginlogs = Loginlogs::find()->orderBy(['login_date'=>SORT_DESC])->one();
        $userid = $loginlogs['user_id'];
        $user = User::find()->where(['user_id'=>$userid])->one();
        $profile = Profile::find()->where(['user_id'=>$userid])->one();
        // $test =  Profile::find()->one();
        $rstlid = $profile['rstl_id'];
        $fullname = $profile['firstname'] . " " . $profile['lastname'] . "- RSTL ID : " . $profile['rstl_id'];
        $curl = curl_init();
        $user_data = array('email'=>$user['email']);
       
        curl_setopt($curl, CURLOPT_POST, 1);
    
        curl_setopt($curl, CURLOPT_URL, 'https://eulims.onelab.ph/api/sync/verifylogin');

        // Make it so the data coming back is put into a string
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_PROXY, ''); //!! FIX
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
        $result = curl_exec($curl);
        $reqtoken = array();
        $reqtoken =  json_decode($result, true);
      
        $result = curl_exec($curl);
        $reqtoken = array();
        $reqtoken =  json_decode($result, true);

        $session = new Session;
        $session['sessiontoken'] = $reqtoken['token'];

        $generatedtoken = $reqtoken['token'];
            if($generatedtoken == '')
            {
                SchedsyncController::sendemailerror('cronbookinglocal',$profile->rstl_id,'Token not generated');
                exit();
            }

        $booking = Booking::find()->select(['booking_reference'])->asArray()->all();
        $data_sync = array('rstl_id'=>$rstlid );
        $booking_list = SchedsyncController::callrestapireturn('POST', 'https://eulims.onelab.ph/api/sync/syncgetbooking', $data_sync);
        //  echo count($booking_list);
       
        if ($booking_list) {
            foreach ($booking_list as $rec) {
                $localid = 0;
                $stat = 0;
                if (!is_null($rec['local_booking_id'])) {
                    $localid = $rec['local_booking_id'];
                }
                if (!is_null($rec['customerstat'])) {
                    $stat = $rec['customerstat'];
                }

                $sql = "insert into tbl_booking (
                `rstl_id`,`scheduled_date`,`booking_reference`,`description`,`date_created`,
                `booking_status`,`modeofrelease_ids`,`samplename`, `sampletype_id`,`reason`,`customerstat`,   
               `purpose`,`qty_sample`,`customer_id`)  VALUES(" .
               $rec['rstl_id'] . ",'" . $rec['scheduled_date'] . "','" . $rec['booking_reference'] . "','" . $rec['description'] . "','" . $rec['date_created'] . "',"
               . $rec['booking_status'] . ",'" . $rec['modeofrelease_ids'] . "','" . $rec['samplename'] . "'," . $rec['sampletype_id'] . ",'". $rec['reason'] . "'," . $stat . ",'"
               . $rec['purpose'] . "'," . $rec['qty_sample'] . "," . $rec['customer_id'] . ")";
                //return $sql;
        //    echo $sql .  "\n\r";;
           echo "Booking Local : " . $rec['booking_reference'] . "\n\r"; //$rec['booking_reference;
            Yii::$app->labdb->createCommand($sql)->execute();
                $rec = Booking::find()->where(['booking_reference'=>$rec['booking_reference']])->one();
                $data_sync = array(
                'booking_reference'=>$rec['booking_reference'],
                'local_booking_id'=>$rec['booking_id'],
            );
                SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/syncupdatebooking', $data_sync);
            }
        }
    }

    catch(ErrorException $e)
        {
           
            SchedsyncController::sendemailerror('cronpbookinglocal',$profile->rstl_id,$e);
            exit();
        }

    
}

public static function sendemailerror($cronjob,$rstlid,$error)
    {
        \Yii::$app->mailer->compose()
            ->setFrom('cronjoberror@gmail.com')
            ->setTo('blakadm@gmail.com')
            ->setSubject('Cron Job Error - ' . $cronjob . ' - RSTL ID : ' . $rstlid)
            ->setTextBody($error)
            ->setHtmlBody($error)
            ->send();
    }

public function actionCronrealtime()
    {
        try {
            $loginlogs = Loginlogs::find()->orderBy(['login_date'=>SORT_DESC])->one();
            $userid = $loginlogs['user_id'];
            $user = User::find()->where(['user_id'=>$userid])->one();
            $profile = Profile::find()->where(['user_id'=>$userid])->one();
            // $test =  Profile::find()->one();
            $rstlid = $profile['rstl_id'];
            $fullname = $profile['firstname'] . " " . $profile['lastname'];
            $curl = curl_init();
            $user_data = array('email'=>$user['email']);
       
            curl_setopt($curl, CURLOPT_POST, 1);
    
            curl_setopt($curl, CURLOPT_URL, 'https://eulims.onelab.ph/api/sync/verifylogin');

            // Make it so the data coming back is put into a string
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_PROXY, ''); //!! FIX
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
            $result = curl_exec($curl);
            $reqtoken = array();
            $reqtoken =  json_decode($result, true);
      
            $result = curl_exec($curl);
            $reqtoken = array();
            $reqtoken =  json_decode($result, true);

            $session = new Session;
            $session['sessiontoken'] = $reqtoken['token'];

            $generatedtoken = $reqtoken['token'];
            if($generatedtoken == '')
            {
                SchedsyncController::sendemailerror('cronrealtime',$profile->rstl_id,'Token not generated');
                exit();
            }

      
            // $paramID =Yii::$app->user->identity->profile->rstl_id;// Yii::$app->request->get('rstlid');
            //  $model = new $this->modelClass;
    
            $rstlId = $rstlid;
            $now = new DateTime();

            $currentyear=$now->format('Y');
            $currentmonth= $now->format('m');
       
            $currentmonthchar=substr(strtolower(date('F', mktime(0, 0, 0, $currentmonth, 1))), 0, 3); //strtolower($now->format('M'));
       
            $kpi = ['samples','tests','customers','newcustomers','firms','fees','csi'];
            foreach ($kpi as $kpirec) {
                Yii::$app->labdb->createCommand("CALL spPerformanceDashboardRealtime('" . $kpirec . "'," . $currentmonth . ",'" . $currentmonthchar  . "',". $currentyear .",'Accomplishments','". $rstlId ."');")->execute();
            }
 
            //  $rstl = AccomplishmentRstl::find(['yeardata'=>'2020'])->andWhere(['type'=>'Accomplishments'])->andWhere(['rstl_id'=>$rstlId])->all();
            $querySql =  Yii::$app->labdb->createCommand("SELECT * from tbl_accomplishment_rstl where yeardata = ". $currentyear . " and `type`='Accomplishments' and rstl_id = " . $rstlId)->queryAll();
      
            //   $counter =  Yii::$app->labdb->createCommand("SELECT * from tbl_accomplishment_rstl where yeardata = ". $currentyear . " and `type`='Accomplishments' and rstl_id = " . $rstlId)->queryScalar();
      
            $rstlArray = array();
            foreach ($querySql   as $eachRow) {
         
         // echo $recData['indicator'] . " " . $recData['chem'] . "\n";

                $data_sync = array(
            'curmonth'=>$currentmonth,
            'curyear'=>$currentyear,
            'fullname'=>$fullname,
            'rstl_id'=>$eachRow['rstl_id'],
            'indicator'=>$eachRow['indicator'],
            'type'=>$eachRow['type'],
            'chem'=> $eachRow[$currentmonthchar.'chem'],
            'micro'=>$eachRow[$currentmonthchar.'micro'],
            'metro'=>$eachRow[$currentmonthchar.'metro'],

            'halal'=> $eachRow[$currentmonthchar.'halal'],
           // 'sync_date'=>date('Y-m-d H:i:s'),
        );
                SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/syncupdatedashboard', $data_sync);
                echo 'Realtime : ' . $eachRow['indicator'] . ' inserted.' . "\n\r";
                // array_push($rstlArray,$recData);
            };
        }

        catch(ErrorException $e)
        {
           // echo $e;
            //echo "Exception caught";
            SchedsyncController::sendemailerror('cronprealtime',$profile->rstl_id,$e);
            exit();
        }



        //$booking = Booking::find()->select(['booking_reference'])->asArray()->all();


        //$data_sync = array('rstl_id'=>$rstlid );
        //$booking_list = SchedsyncController::callrestapireturn('POST', 'https://eulims.onelab.ph/api/sync/syncgetbooking', $data_sync);
    }

    // -----------------------------   SYNCING FUNCTIONS

    public static function Savesynccustomer($rstlid,$fullname)
    {
           $customer_list = SchedsyncController::Retrieveids('customer',0,$rstlid);
   //  echo count($customer_list);
           $customer = Customer::find()->where(['IN','customer_id',$customer_list])->all();
            if ($customer) {
                echo 'Start Customer syncing...' . "\r\n";
                $custcount = 1;
                foreach ($customer as $rec) {
                    $data_sync = array(
                   // 'rstl_id'=>Yii::$app->user->identity->profile->rstl_id,
                    'rstl_id'=>$rstlid,
                    'customer_id'=>$rec->customer_id,
                    'email'=>$rec->email,
                    'customer_name'=>$rec->customer_name,
                    'address'=>$rec->address,
                    'tel'=>$rec->tel,
                    'business_nature_id'=>$rec->business_nature_id,
                    'industrytype_id'=>$rec->industrytype_id,
                    'customer_type_id'=>$rec->customer_type_id,
                   // 'sync_by'=>Yii::$app->user->identity->profile->fullname,
                    'sync_by'=>$fullname,
                    'sync_date'=>  date('Y-m-d H:i:s'));

           
                    //return $this->asJson($data_sync);
                    $returnvalue = SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesynccustomer', $data_sync);
                    
                    echo $custcount . '. Customer: ' .$rec->customer_name . ' inserted ' . "\r\n";
                    $custcount++;
                    // if(is_array(json_decode($returnvalue)))
                    // {
                    //     echo 'error';
                    // }
                    // else
                    // {
                    //     echo $returnvalue . "\r\n";
                    // }
                    // if (trim($returnvalue) == 'Record Saved') {
                    //     echo $custcount . '. Customer: ' .$rec->customer_name . ' inserted ' . "\r\n";
                    //     $custcount++;
                    // }
                    // else
                    // {
                    //     \Yii::$app->mailer->compose()
                    //     ->setFrom('eulims.onelab@gmail.com')
                    //     ->setTo('blakadm@gmail.com')
                    //     ->setSubject('Error in Customer Syncing')
                    //     ->setTextBody('RSTL - 11 ' . $rec->customer_name . ' - ' . $rec->customer_id)
                    //    // ->setHtmlBody($content)
                    //     ->send();
                    // }
                    
                   
                }
            }
            return 'done';
         //  return  $customer_list;    
           // 
    }


    public static function Synccustomeraccount($rstlid)
    {
        // $test =  Profile::find()->one();
     
        // $api_param = array(
        //     'rstl_id'=> $test['rstl_id']);
            
        
     //   $customer_list =   SchedsyncController::callrestapireturn('POST', 'http://eulims.onelab.ph/api/sync/synccustacct', $api_param);
        
       //  foreach ($customer_list as $rec) 
      //   {
         //SchedsyncController::Savesyncrequest($rec['customer_id']);
       //  SchedsyncController::Savesyncsample($rec['customer_id'],$rstlid);
         // SchedsyncController::Savesyncbooking($rec['customer_id']);
         // SchedsyncController::Savesynccustwallet($rec['customer_id']);
        //    SchedsyncController::Savesynccusttrans($rec['customer_id']);

       //  }



        //     $req_list = Request::find()->select('request_id')->where(['customer_id'=>$rec['customer_id']])->all();
        
        // return $req_list;
    }


    public static function Savesyncrequest($customer_id,$rstlid,$fullname)
    {
            $request_list = SchedsyncController::Retrieveids('request',$customer_id,$rstlid);
            
            
           $request = Request::find()->where(['IN','request_id',$request_list])->all();
        if ($request) {
            $reqcount=1;
            foreach ($request as $rec) {
                $data_sync = array(
                'rstl_id'=>$rstlid,
                'request_id'=>$rec->request_id,
                'request_ref_num'=>$rec->request_ref_num,
                'request_datetime'=>$rec->request_datetime,
                'sync_by'=>$fullname,
                'customer_id'=>$rec->customer_id,
                'status_id'=>$rec->status_id,
                'sync_date'=> date('Y-m-d H:i:s'),
            );
            SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesyncrequest', $data_sync);
            echo $reqcount . '. Request : ' . $rec->request_ref_num . ' inserted ' . "\r\n";
            $reqcount++;
            }
        }
        return 'done';
     //         return $request;    
           // 
    }

    public static function Savesyncsample($customer_id,$rstlid,$fullname)
    {
           $sample_list = SchedsyncController::Retrieveids('sample',$customer_id,$rstlid);
            
           $sample = Sample::find()->where(['IN','sample_id',$sample_list])->all();
            if ($sample) {
            $samcount=1;
               foreach ($sample as $rec) {
                    $data_sync = array(
                    'rstl_id'=>$rstlid,//Yii::$app->user->identity->profile->rstl_id,
                    'sample_id'=>$rec->sample_id,
                    'samplecode'=>$rec->sample_code,
                    'samplename'=>$rec->samplename,
                    'request_id'=>$rec->request_id,
                    'completed'=>$rec->completed,
                    'sync_by'=>$fullname,//Yii::$app->user->identity->profile->fullname,
                    'sync_date'=>  date('Y-m-d H:i:s'));
           
                    //return $this->asJson($data_sync);
                   $test = SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesyncsample', $data_sync);
                  echo $samcount . '. Sample : ' . $rec->sample_id . ' inserted ' . "\r\n";
                  // echo $test;
                    $samcount++;
               }
            }
            return 'done';
       //   echo  $sample_list;    
           // 
    }

   
    public static function Savesyncsampletype($customer_id,$rstlid,$fullname)
    {
            $sampletype_list = SchedsyncController::Retrieveids('sampletype',$customer_id,$rstlid);
            
            
           $sampletype = Sampletype::find()->where(['IN','sampletype_id',$sampletype_list])->all();
            if ($sampletype) {
                $samcount=1;
                foreach ($sampletype as $rec) {
                    $data_sync = array(
                    'rstl_id'=>$rstlid,//Yii::$app->user->identity->profile->rstl_id,
                    'sampletype_id'=>$rec->sampletype_id,
                    'type'=>$rec->type,
                    'status_id'=>$rec->status_id,
                    'sync_by'=>$fullname,//Yii::$app->user->identity->profile->fullname,
                    'sync_date'=>  date('Y-m-d H:i:s'));
                   
                   
                    //return $this->asJson($data_sync);
                 SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesyncsampletype', $data_sync);
                   echo $samcount . '. SampleType : ' . $rec->type . ' inserted ' . "\r\n";
                    $samcount++;
                }
            }
            return 'done';
           //  echo  count($sampletype_list);    
           // 
    }

    public static function Savesynccustomeracct($rstlid)
    {
            $acct_list = SchedsyncController::Retrieveids('custacct',0,$rstlid);
            
        
           $custacct = Customeraccount::find()->where(['IN','customeraccount_id',$acct_list])->all();
            if ($custacct) 
            {
               
               foreach ($custacct as $rec) 
               {
                    $data_sync = array(
                'rstl_id'=>$rstlid,//Yii::$app->user->identity->profile->rstl_id,
                'customer_id'=>$rec->customer_id,
                'password_hash'=>$rec->password_hash,
                'auth_key'=>$rec->auth_key,
                'status'=>$rec->status,
                'lastlogin'=>$rec->lastlogin,
                'verifycode'=>$rec->verifycode,
                'created_at'=>$rec->created_at,
                'updated_at'=>$rec->updated_at,
                'customeraccount_id'=>$rec->customeraccount_id,
                'sync_by'=>'',//Yii::$app->user->identity->profile->fullname,
                'sync_date'=>  date('Y-m-d H:i:s')
                    );

             //      return $data_sync;
           SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesynccustomeraccount', $data_sync);
    
          
            }
        }
  // return $acct_list;
    }

    public static function Savesynccustwallet($customer_id,$rstlid,$fullname)
    {
            $wallet_list = SchedsyncController::Retrieveids('customerwallet',$customer_id,$rstlid);
            
            
           $wallet = Customerwallet::find()->where(['IN','customerwallet_id',$wallet_list])->all();
           if ($wallet) 
           {
            $walletcount=1;
               foreach ($wallet as $rec) {
                   $data_sync = array(
            'rstl_id'=>$rstlid,//Yii::$app->user->identity->profile->rstl_id,
            'date'=>$rec->date,
            'last_update'=>$rec->last_update,
            'balance'=>$rec->balance,
            'customer_id'=>$rec->customer_id,
            'local_customerwallet_id'=>$rec->customerwallet_id,
            'sync_by'=>$fullname,//Yii::$app->user->identity->profile->fullname,
            'sync_date'=>  date('Y-m-d H:i:s'));
                   // return $this->asJson($data_sync);
              SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesynccustomerwallet', $data_sync);
              echo $walletcount . '. Wallet : ' . $rec->customer_id . ' inserted ' . "\r\n";
              $walletcount++;
               }
           }

           return 'done';
   // return $wallet_list;
    }

    public static function Savesynccusttrans($customer_id,$rstlid,$fullname)
    {
            $custtran_list = SchedsyncController::Retrieveids('customertran',$customer_id,$rstlid);
            
            
           $customertran = Customertransaction::find()->where(['IN','customertransaction_id',$custtran_list])->orderBy(['customertransaction_id'=>SORT_ASC])->all();
            if ($customertran) 
            {
                $wallettrancount = 1;
                foreach ($customertran as $rec) {
                  
                        $data_sync = array(
                        'rstl_id'=>$rstlid,//Yii::$app->user->identity->profile->rstl_id,
                        'date'=>$rec->date,
                        'transactiontype'=>$rec->transactiontype,
                        'balance'=>$rec->balance,
                        'amount'=>$rec->amount,
                        'customerwallet_id'=>$rec->customerwallet_id,
                        'collection_id'=>$rec->collection_id,
                        'source'=>$rec->source,
                        'local_customertransaction_id'=>$rec->customertransaction_id,
                        'updated_by'=>$rec->updated_by,
                        'sync_by'=>$fullname,//Yii::$app->user->identity->profile->fullname,
                        'sync_date'=> date('Y-m-d H:i:s')
                       
                    );
                   // return $this->asJson($data_sync);
               SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesynccustomertran', $data_sync);
               echo $wallettrancount . '. Wallet Transaction : ' . $rec->date . ' inserted ' . "\r\n";
               $wallettrancount++;
             }
            }
        //    return $custtran_list;    
           // 
    }

    public static function Savesyncbooking($customer_id,$rstlid,$fullname)
    {
        $booking_list = SchedsyncController::Retrieveids('booking',$customer_id,$rstlid);
        echo 'booking online count : ' . count($booking_list);
     
        $booking = Booking::find()->where(['IN','booking_reference',$booking_list])->all();
        //$booking = Booking::find()->all();
        echo 'booking : ' . count($booking) . ' ------';
        if ($booking) {
            $bookcount=1;
            foreach ($booking as $rec) 
            {
               
                $data_sync = array(
                'rstl_id'=>$rstlid, //$rec->rstl_id,
            //  'booking_id'=>$booking->booking_id,
                'scheduled_date'=>$rec->scheduled_date,
                'booking_reference'=>$rec->booking_reference,
                'description'=>$rec->description,
                'date_created'=>$rec->date_created,
                'booking_status'=>$rec->booking_status,
                'modeofrelease_ids'=>$rec->modeofrelease_ids,
                'samplename'=>$rec->samplename,
                'sampletype_id'=>$rec->sampletype_id,
                'reason'=>$rec->reason,
                'customerstat'=>$rec->customerstat,
                'purpose'=>$rec->purpose,
                'qty_sample'=>$rec->qty_sample,
                'customer_id'=>$rec->customer_id,
                'sync_by'=>$fullname,//Yii::$app->user->identity->profile->fullname,
                'sync_date'=> date('Y-m-d H:i:s'),
                'local_booking_id'=>$rec->booking_id,
            // 'xxx'=>Yii::$app->user->identity->profile->fullname,
        );
                //  return $this->asJson($data_sync);
            SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesyncbooking', $data_sync);
            echo $bookcount . '. Booking  : ' . $rec->booking_reference . ' inserted ' . "\r\n";
            $bookcount++;
        }
        }
    return 'done';
   // return $booking_list;
    }
            
           
    public static function Savesyncpurpose()
    {
          $purpose_list = SchedsyncController::Retrieveids('purpose',0,11);
           $purpose = Purpose::find()->where(['IN','purpose_id',$purpose_list])->all();
           if($purpose)
           {
            foreach ($purpose as $rec) {
                $data_sync = array(
                    'rstl_id'=>11,//Yii::$app->user->identity->profile->rstl_id,
                    'name'=>$rec->name,
                    'active'=>$rec->active,
                    'local_purpose_id'=>$rec->purpose_id,
                    'sync_by'=>'',//Yii::$app->user->identity->profile->fullname,
                    'sync_date'=>date('Y-m-d H:i:s'),
                );
              SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesyncpurpose', $data_sync);
            }


           }
            
        return  $data_sync; 
    }
    public static function Savesyncmode()
    {
            $mode_list = SchedsyncController::Retrieveids('mode',0,11);
            
            
           $mode = Modeofrelease::find()->where(['IN','modeofrelease_id',$mode_list])->all();

           if($mode)
           {
            foreach ($mode as $rec) {
           
                    $data_sync = array(
                        'rstl_id'=>11,//Yii::$app->user->identity->profile->rstl_id,
                        'mode'=>$rec->mode,
                        'status'=>$rec->status,
                        'local_modeofrelease_id'=>$rec->modeofrelease_id,
                        'sync_by'=>'',//Yii::$app->user->identity->profile->fullname,
                        ' sync_date'=>date('Y-m-d H:i:s'),
                       
                    );
                   // return $this->asJson($data_sync);
                 SchedsyncController::callrestapi('POST', 'https://eulims.onelab.ph/api/sync/savesyncmode', $data_sync);
                   
            }
           }
            
    }

    

    public static function Retrieveids($tbl,$customerid,$rstlid)
    {
        $list_local=array();
        $list_fromapi=array();
        $compare_id='';
        $compare_id_sync='';
       
        switch($tbl)
        {

            case 'customer':

                $customer = Request::find()->select(['customer_id'])
                ->where(['YEAR(request_datetime)'=>2020])
                ->andWhere(['>=','MONTH(request_datetime)',9])->orderBy(['customer_id'=>SORT_ASC])
                ->groupBy(['customer_id'])
                ->asArray()->all();

                // $customer = Customer::find()->select(['customer_id'])
                // // ->where(['status_id'=>1])
                //     //    ->andWhere(['>=','MONTH(request_datetime)',9])
                //         ->asArray()->all();
                        $list_local = $customer;
                        $compare_id = 'customer_id';
                        $compare_id_sync = 'customer_id';
            break;

            case 'request':
                // $request = Request::find()->select(['request_id'])
                // ->where(['YEAR(request_datetime)'=>2020])
                // ->andWhere(['>=','MONTH(request_datetime)',9])
                $request = Request::find()->select('request_id')->where(['customer_id'=>$customerid])
                ->asArray()->all();


                $list_local = $request;
                $compare_id = 'request_id';
                $compare_id_sync = 'request_id';
            break;

            case 'sample':
                $request_list = Request::find()->select('request_id')->where(['customer_id'=>$customerid])->all();
                $sample = Sample::find()->select(['sample_id'])->where(['IN','request_id',$request_list])->all();
                        $list_local = $sample;
                        $compare_id = 'sample_id';
                        $compare_id_sync = 'sample_id';
            break;

            case 'sampletype':
            //    $request_list = Request::find()->select('request_id')->where(['customer_id'=>$customerid])->all();
            //    $sample_list = Sample::find()->select(['sampletype_id'])->where(['IN','request_id',$request_list])->groupBy(['sampletype_id'])->all();
                $sampletype = Sampletype::find()->select(['sampletype_id'])->Where(['status_id'=>1])->asArray()->all();
             //   where(['IN','sampletype_id',$sample_list])->andWhere(['status_id'=>1])->asArray()->all();
             //  $sampletype = array();
            //    ->andWhere(['>=','MONTH(request_datetime)',9])
            //    
                $list_local = $sampletype;
                $compare_id = 'sampletype_id';
                $compare_id_sync = 'sampletype_id';
            break;
            case 'customerwallet':
                $wallet = Customerwallet::find()->select(['customerwallet_id'])->where(['customer_id'=>$customerid])
        // ->where(['status_id'=>1])
            //    ->andWhere(['>=','MONTH(request_datetime)',9])
                ->asArray()->all();
                $list_local = $wallet;
                $compare_id = 'customerwallet_id';
                $compare_id_sync = 'local_customerwallet_id';
            break;
            case 'customertran':
                $wallet = Customerwallet::find()->select(['customerwallet_id'])->where(['customer_id'=>$customerid])->one();
                $tran = Customertransaction::find()->select(['customertransaction_id'])->where(['customerwallet_id'=>$wallet['customerwallet_id']])
                // ->where(['status_id'=>1])
                    //    ->andWhere(['>=','MONTH(request_datetime)',9])
                        ->asArray()->all();
                        $list_local = $tran;
                        $compare_id = 'customertransaction_id';
                        $compare_id_sync = 'local_customertransaction_id';
                                            
            break;
            case 'booking':
                $booking = Booking::find()->select(['booking_reference'])->where(['customer_id'=>$customerid])
                // ->where(['status_id'=>1])
                    //    ->andWhere(['>=','MONTH(request_datetime)',9])
                        ->asArray()->all();
                        $list_local = $booking;
                        $compare_id = 'booking_reference';
                        $compare_id_sync = 'booking_reference';
            break;
            case 'purpose':
                $purpose = Purpose::find()->select(['purpose_id'])
                // ->where(['status_id'=>1])
                    //    ->andWhere(['>=','MONTH(request_datetime)',9])
                        ->asArray()->all();
                        $list_local = $purpose;
                        $compare_id = 'purpose_id';
                        $compare_id_sync = 'local_purpose_id';
            break;
            case 'mode':
                $mode = Modeofrelease::find()->select(['modeofrelease_id'])
                // ->where(['status_id'=>1])
                    //    ->andWhere(['>=','MONTH(request_datetime)',9])
                        ->asArray()->all();
                        $list_local = $mode;
                        $compare_id = 'modeofrelease_id';
                        $compare_id_sync = 'local_modeofrelease_id';
            break;
            case 'custacct':
                $custacct = Customeraccount::find()->select(['customeraccount_id'])
                // ->where(['status_id'=>1])
                    //    ->andWhere(['>=','MONTH(request_datetime)',9])
                        ->asArray()->all();
                        $list_local = $custacct;
                        $compare_id = 'customeraccount_id';
                        $compare_id_sync = 'local_customeraccount_id';
            break;
           
           
        }

       
        $api_param = array(
            'rstl_id'=>$rstlid,// Yii::$app->user->identity->profile->rstl_id,
            'tbl'=>$tbl);
      
        $list_fromapi =   SchedsyncController::callrestapireturn('POST', 'https://eulims.onelab.ph/api/sync/syncgetids', $api_param);
     //  echo count($list_fromapi);
        if ($list_fromapi || $list_local) {

           $localids = array();
           $syncids = array();
           if (count($list_local)<> 0) {
               foreach ($list_local as $rec) {
                   $recdata = $rec[$compare_id];
                   array_push($localids, $recdata);
               }
           }
            if ($list_fromapi <> 0) {
                foreach ($list_fromapi as $rec) {
                    $recdata = $rec[$compare_id_sync];
                   
                    array_push($syncids, $recdata);
                }
            }
        

            $result = array_diff($localids, $syncids);
            
            return $result;
        // echo count($localids);

          // echo $result;
        //   if($list_fromapi <> 0)
        //   {
        //     echo 'Not 0';
        //   }
        //   else
        //   {
        //     echo 'Test 0';
        //   }
       //  echo $list_fromapi;
        // }
        // else
        // {
        //    return '0';
        //    // return $this->asJson($request);
     }

    }
    public static function callrestapi($mode,$apiurl,$fieldsarray)
    {
        $session = new Session();
      //  $cookies = Yii::$app->request->cookies;
        $token = $session['sessiontoken'];// $cookies->getValue('verifytoken');
      //  echo $token;
        $auth = array("Authorization: Bearer ".  $token);
      //  $data = array();
        $data = $fieldsarray;
      
        $curl = curl_init();
               if ($mode == 'POST') {
                curl_setopt($curl, CURLOPT_POST, 1); // GET - Remove
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
               }
                curl_setopt($curl, CURLOPT_HTTPHEADER, $auth);
                curl_setopt($curl, CURLOPT_URL, $apiurl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_PROXY, ''); //!! FIX
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
               
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_TIMEOUT, 10000);
              
                $result = curl_exec($curl);
               // $reqtoken =  json_decode($result, true); 
               // var_dump($result);
 //    echo $result;
                $info = curl_getinfo($curl);
                $retval =  json_decode($result, true);
                // echo 'content type: ' . $info['content_type'] . '<br />';
                // echo 'http code: ' . $info['http_code'] . "\r\n";
               // echo $result;
               return $result;
               curl_close($curl);


             
    }

    public static function callrestapireturn($mode,$apiurl,$fieldsarray)
    {
        $session = new Session();
        //  $cookies = Yii::$app->request->cookies;
          $token = $session['sessiontoken'];// $cookies->getValue('verifytoken');
        $auth = array("Authorization: Bearer ".  $token);
      //  $data = array();
        $data = $fieldsarray;
      
        $curl = curl_init();
               if ($mode == 'POST') {
                curl_setopt($curl, CURLOPT_POST, 1); // GET - Remove
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                
               }

                curl_setopt($curl, CURLOPT_HTTPHEADER, $auth);
                curl_setopt($curl, CURLOPT_URL, $apiurl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_PROXY, ''); //!! FIX
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
             //   
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
              
                $result = curl_exec($curl);
         //       echo $result;
                if( $result === null || $result == FALSE || $result == '' )
                {
                    $returnvalue=0;
                }
                else
                {
                    $returnvalue =  json_decode($result, true);
                }
                 
               
                curl_close($curl);
               return  $returnvalue;
    }



}   
