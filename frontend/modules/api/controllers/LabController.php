<?php 

namespace frontend\modules\api\controllers;
use yii\web\Controller;
use Yii;
use linslin\yii2\curl;
use common\models\lab\Restore;
use common\models\lab\Restore_request;
use common\models\lab\Restore_customer;
use common\models\lab\Restore_sample;
use common\models\lab\Restore_analysis;
use common\models\lab\Sample;
use common\models\lab\Backup;
use common\models\lab\Request;
use common\models\lab\Analysis;
use common\models\lab\Customer;
use common\models\lab\BackuprestoreSearch;
use common\models\lab\Backuprestore;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\ActiveDataProvider;

set_time_limit(5000);

/**
 * Default controller for the `Lab` module
 */
class LabController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
     public function actionIndex()
     {
         $searchModel = new BackuprestoreSearch();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         
        $model = new Backuprestore();


        $request = Request::find()->count();
        $customer = Customer::find()->count();
        $analysis = Analysis::find()->count();
        $sample = Sample::find()->count();
    
        //customer
        $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
        $apiUrl_customer="https://eulimsapi.onelab.ph/api/web/v1/customers/countcustomer?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_customer = curl_init();			
        curl_setopt($curl_customer, CURLOPT_URL, $apiUrl_customer);
        curl_setopt($curl_customer, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_customer, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_customer, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_customer, CURLOPT_RETURNTRANSFER, true);
        $response_customer = curl_exec($curl_customer);			
        $data_customer = json_decode($response_customer, true);
    
        //analysis
        $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
        $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/countrequest?rstl_id=".$GLOBALS['rstl_id'];        
        $curl = curl_init();			
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);			
        $data = json_decode($response, true);
    
        //analysis
        $apiUrl_analysis="https://eulimsapi.onelab.ph/api/web/v1/analysisdatas/countanalysis?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_analysis = curl_init();			
        curl_setopt($curl_analysis, CURLOPT_URL, $apiUrl_analysis);
        curl_setopt($curl_analysis, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_analysis, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_analysis, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_analysis, CURLOPT_RETURNTRANSFER, true);
        $response_analysis = curl_exec($curl_analysis);			
        $data_analysis = json_decode($response_analysis, true);
    
        //sample
        $apiUrl_sample="https://eulimsapi.onelab.ph/api/web/v1/samples/countsample?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_sample = curl_init();			
        curl_setopt($curl_sample, CURLOPT_URL, $apiUrl_sample);
        curl_setopt($curl_sample, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_sample, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_sample, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_sample, CURLOPT_RETURNTRANSFER, true);
        $response_sample = curl_exec($curl_sample);			
        $data_sample = json_decode($response_sample, true);


         return $this->render('backup_restore', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
             'model'=>$model,
             'data_analysis'=>$data_analysis,
             'data_sample'=>$data_sample,
             'data_customer'=>$data_customer,
             'data'=>$data,
             'request'=>$request,
             'customer'=>$customer,
             'analysis'=>$analysis,
             'sample'=>$sample
         ]);
     }

     public function actionRestore()
     {
        $restore= Restore::find();
        $restoredataprovider = new ActiveDataProvider([
                    'query' => $restore,
                    'pagination' => [
                        'pageSize' => false,
                            ],                 
            ]);

        

         return $this->render('restore', [
             'restoredataprovider' => $restoredataprovider,
         ]);
     }

     public function actionBackup()
     {
        $backup= Backup::find();
        $restoredataprovider = new ActiveDataProvider([
                    'query' => $backup,
                    'pagination' => [
                        'pageSize' => false,
                            ],                 
            ]);

        

         return $this->render('backup', [
             'restoredataprovider' => $restoredataprovider,
         ]);
     }

     public function actionRessync(){
         //TAKE NOTE OF THE REQUEST OLD ID KAPAG HINDI GALING SA YII
        $searchModel = new BackuprestoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Backuprestore();

            #All data are sync

            $request = Request::find()->count();
        
            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
            $apiUrls="https://eulimsapi.onelab.ph/api/web/v1/requests/countrequest?rstl_id=".$GLOBALS['rstl_id'];        
            $curls = curl_init();			
            curl_setopt($curls, CURLOPT_URL, $apiUrls);
            curl_setopt($curls, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curls, CURLOPT_SSL_VERIFYHOST, FALSE); 
            curl_setopt($curls, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
            curl_setopt($curls, CURLOPT_RETURNTRANSFER, true);
            $responses = curl_exec($curls);			
            $api = json_decode($responses, true);

            if ($request>=$api){
                $message = "All data are sync";
                return Json::encode([
                    'message'=>$message,        
                ]);
                exit;
            }
        	           
         $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
     
         $lastid =  Backuprestore::find()->max('last_num');  
          
         $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restoresyncnew?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&id=".$lastid;

            $curl = curl_init();                   
            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
                
            $data = json_decode($response, true);
             
            $sql = "SET FOREIGN_KEY_CHECKS = 0;";
            $connection = Yii::$app->labdb;
            
           
            $transaction = $connection->beginTransaction();
            $connection->createCommand('set foreign_key_checks=0')->execute();
          
              foreach ($data as $request)
              {    
                          $newRequest = new Restore_request();    
                          $newRequest->request_id = $request['request_old_id'];
                          $newRequest->request_ref_num = $request['request_ref_num'];
                          $newRequest->request_datetime= $request['request_datetime'];
                          $newRequest->rstl_id= $request['rstl_id'];
                          $newRequest->lab_id= $request['lab_id'];
                          $newRequest->customer_id= $request['customer_id'];
                          $newRequest->payment_type_id= $request['payment_type_id'];
                          $newRequest->modeofrelease_ids= $request['modeofrelease_ids'];
                          $newRequest->discount = $request['discount'];
                          $newRequest->purpose_id= $request['purpose_id'];
                          $newRequest->conforme= $request['conforme'];
                          $newRequest->report_due= $request['report_due'];
                          $newRequest->total = $request['total'];
                          $newRequest->receivedBy = $request['receivedBy'];
                          $newRequest->recommended_due_date = $request['recommended_due_date'];
                          $newRequest->est_date_completion = $request['est_date_completion'];
                          $newRequest->items_receive_by = $request['items_receive_by'];
                          $newRequest->equipment_release_date = $request['equipment_release_date'];
                          $newRequest->certificate_release_date = $request['certificate_release_date'];
                          $newRequest->released_by = $request['released_by'];
                          $newRequest->posted = $request['posted'];
                          $newRequest->status_id = $request['status_id'];
                          $newRequest->selected = $request['selected'];
                          $newRequest->other_fees_id = $request['other_fees_id'];
                          $newRequest->request_type_id = $request['request_type_id'];
                          $newRequest->position = $request['position'];
                          $newRequest->completed = $request['completed'];
                          $newRequest->received_by = $request['received_by'];
                          $newRequest->payment_status_id = $request['payment_status_id'];
                          $newRequest->oldColumn_requestId= $request['oldColumn_requestId'];
                          $newRequest->oldColumn_sublabId= $request['oldColumn_sublabId'];
                          $newRequest->oldColumn_orId = $request['oldColumn_orId'];
                          $newRequest->oldColumn_completed= $request['oldColumn_completed'];
                          $newRequest->oldColumn_cancelled= $request['oldColumn_cancelled'];
                          $newRequest->oldColumn_create_time= $request['oldColumn_create_time'];
                          $newRequest->request_old_id= $request['request_old_id'];
                          $newRequest->created_at= $request['created_at'];
                          $newRequest->discount_id= $request['discount_id'];
                          $newRequest->customer_old_id= $request['customer_old_id'];
                          $newRequest->tmpCustomerID= $request['tmpCustomerID'];
                          $newRequest->save();
                         
                         
                          foreach ($request['sample'] as $samp){
                                   
                              $newSample = new Restore_sample();
                              $newSample->rstl_id=$samp['rstl_id'];
                             // $newSample->sample_id=$samp['sample_old_id'];
                              $newSample->sample_id=$samp['sample_id'];
                              $newSample->pstcsample_id=$samp['pstcsample_id'];
                              $newSample->sampletype_id=$samp['sampletype_id'];
                              $newSample->package_id=$samp['package_id'];
                              $newSample->package_rate=$samp['package_rate'];
                              $newSample->sample_code=$samp['sample_code'];
                              $newSample->samplename=$samp['samplename'];
                              $newSample->description=$samp['description'];
                              $sampdate = $samp['sampling_date'];        
                                    if ($sampdate=="0000-00-00 00:00:00"){
                                            $newSample->sampling_date=null;
                                    }else{
                                            $newSample->sampling_date=$sampdate;
                                    }                        
                              $newSample->remarks=$samp['remarks'];
                              $newSample->request_id=$samp['old_request_id'];
                              $newSample->sample_month=$samp['sample_month'];
                              $newSample->sample_year=$samp['sample_year'];
                              $newSample->active=$samp['active'];
                              $newSample->sample_old_id=$samp['sample_old_id'];
                              $newSample->oldColumn_requestId=$samp['oldColumn_requestId'];
                              $newSample->oldColumn_completed=$samp['oldColumn_completed'];
                              if ($datedisposed="0000-00-00"){
                                $newSample->oldColumn_datedisposal=null;
                              }else{
                                $newSample->oldColumn_datedisposal=$datedisposed;
                              }
                              $newSample->oldColumn_mannerofdisposal=$samp['oldColumn_mannerofdisposal'];
                              $newSample->oldColumn_batch_num=$samp['oldColumn_batch_num'];
                              $newSample->oldColumn_package_count=$samp['oldColumn_package_count'];
                              $newSample->testcategory_id=$samp['testcategory_id'];
                              $newSample->save(true); 

                        foreach ($samp['analyses'] as $anals){
                            $newanalysis = new Restore_analysis();
                           // $newanalysis->analysis_id=$anals['analysis_old_id'];
                            $newanalysis->analysis_id=$anals['analysis_id'];
                            $newanalysis->rstl_id=$anals['rstl_id'];
                            $newanalysis->pstcanalysis_id=$anals['pstcanalysis_id'];
                            $newanalysis->sample_id =$anals['old_sample_id'];
                            $newanalysis->sample_code=$anals['sample_code'];
                            $newanalysis->testname=$anals['testname'];
                            $newanalysis->method=$anals['method'];
                            $newanalysis->references=$anals['references'];
                            $newanalysis->quantity=$anals['quantity'];
                            $newanalysis->fee=$anals['fee'];
                            $newanalysis->test_id=$anals['test_id'];
                            $newanalysis->cancelled=$anals['cancelled'];
                            $newanalysis->date_analysis=$anals['date_analysis'];
                            $newanalysis->user_id=$anals['user_id'];
                            $newanalysis->is_package=$anals['is_package'];
                            $newanalysis->oldColumn_deleted=$anals['oldColumn_deleted'];
                            $newanalysis->analysis_old_id=$anals['analysis_old_id'];
                            $newanalysis->oldColumn_taggingId=$anals['oldColumn_taggingId'];
                            $newanalysis->oldColumn_result=$anals['oldColumn_result'];
                            $newanalysis->oldColumn_package_count=$anals['oldColumn_package_count'];
                            $newanalysis->oldColumn_requestId=$anals['oldColumn_requestId'];
                            $newanalysis->request_id =  43;
                            $newanalysis->testcategory_id=$anals['testcategory_id'];
                            $newanalysis->sample_type_id=$anals['sample_type_id'];
                            $newanalysis->old_sample_id=$anals['old_sample_id'];
                            $newanalysis->save(true);  
                            
                    //         foreach ($request['customer'] as $customer){
                    //             $newcustomer = new Restore_customer();
                    //             $cus = Customer::find()->where([ 'customer_id'=>  $customer['customer_old_id']])->one();
                    //             if ($cus){
                    //             }else{
                    //                 $newcustomer->customer_id = $customer['customer_old_id'];
                    //                 $newcustomer->rstl_id = $customer['rstl_id'];
                    //                 $newcustomer->customer_code = $customer['customer_code'];
                    //                 $newcustomer->customer_name = $customer['customer_name'];
                    //                 $newcustomer->classification_id = $customer['classification_id'];
                    //                 $newcustomer->latitude = $customer['latitude'];
                    //                 $newcustomer->longitude = $customer['longitude'];
                    //                 $newcustomer->head = $customer['head'];
                    //                 $newcustomer->barangay_id = $customer['barangay_id'];
                    //                 $newcustomer->address = $customer['address'];
                    //                 $newcustomer->tel = $customer['tel'];
                    //                 $newcustomer->fax = $customer['fax'];
                    //                 $newcustomer->email = $customer['email'];
                    //                 $newcustomer->customer_type_id = $customer['customer_type_id'];
                    //                 $newcustomer->business_nature_id = $customer['business_nature_id'];
                    //                 $newcustomer->industrytype_id = $customer['industrytype_id'];
                    //                 $newcustomer->created_at = $customer['created_at'];
                    //                 $newcustomer->customer_old_id = $customer['customer_old_id'];
                    //                 $newcustomer->Oldcolumn_municipalitycity_id = $customer['Oldcolumn_municipalitycity_id'];
                    //                 $newcustomer->Oldcolumn_district = $customer['Oldcolumn_district'];
                    //                 $newcustomer->local_customer_id = $customer['local_customer_id'];
                    //                 $newcustomer->is_sync_up = $customer['is_sync_up'];
                    //                 $newcustomer->is_updated = $customer['is_updated'];
                    //                 $newcustomer->is_deleted = $customer['is_deleted'];
                    //                 $newcustomer->save(true);
                    //            }
                    //    }
                   }
                  }      
                }
        
                   // Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$year); 
                    $transaction->commit();
                    
                    $sql = "SET FOREIGN_KEY_CHECKS = 1;";

                    $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                    $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/countrequest?rstl_id=".$GLOBALS['rstl_id'];
                    $curl = curl_init();			
                    curl_setopt($curl, CURLOPT_URL, $apiUrl);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
                    curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($curl);			
                    $data = json_decode($response, true);   
                    
                    $model->activity = "Sync all data";
                    $model->date = date('Y-M-d');
                    $model->customer = 1;
                    $model->data =1;
                    $model->status = "COMPLETED";
                    $model->month =1;
                    $model->monthyear = 1;
                    $model->last_num = $data;
                    $analysis_count = 1;
                    $model->year = $analysis_count."/".$analysis_count;
                    Yii::$app->session->setFlash('success', 'Sync all data'); 
                    $model->save(false);
          
        $message = "Sync all data";
        return Json::encode([
            'message'=>$message,    
        ]);
        exit;
              return $this->renderAjax('/lab/backup_restore', [
                 'model'=>$model,
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]);  


     }


     public function actionRes(){
         //by year	

		$searchModel = new BackuprestoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Backuprestore();
        	 
        $month = $_POST['month'];
        $year =  $_POST['year'];
            
         if ($month=="January"){
            $month_value = "01";
        }elseif ($month=="February"){
            $month_value = "02";
        }elseif ($month=="March"){
            $month_value = "03";
        }elseif ($month=="April"){
            $month_value = "04";
        }elseif ($month=="May"){
            $month_value = "05";
        }elseif ($month=="June"){
            $month_value = "06";
        }elseif ($month=="July"){
            $month_value = "07";
        }elseif ($month=="August"){
            $month_value = "08";
        }elseif($month=="September"){
            $month_value = "09";
        }elseif($month=="October"){
            $month_value = "10";
        }elseif ($month=="November"){
            $month_value = "11";
        }elseif ($month=="December"){
            $month_value = "12";
        }
        $br = Backuprestore::find()->where([ 'monthyear'=> $month_value.$year])->one();

       if ($br) {
            $message = "The month you have selected has been succesfully restored.";
            return Json::encode([
                'message'=>$message,        
            ]);
            exit;
            }

          

        for($month=1;$month < 13;$month++){
            $request_count = 0;
            $sample_count = 0;
            $analysis_count = 0;
            $samplenum = 0;
            $analysesnum = 0;
            if ($month>9){
                $start = $year."-".$month;
                $end = $year."-".$month;
            }else{
                $start = $year."-"."0".$month;
                $end = $year."-"."0".$month;
            }
                 
            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
            $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&reqds=".$start."&reqde=".$end;
                
            $curl = curl_init();                   
            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
                
            $data = json_decode($response, true);
             
            $sql = "SET FOREIGN_KEY_CHECKS = 0;";
            $connection = Yii::$app->labdb;
            
           

            $transaction = $connection->beginTransaction();
            $connection->createCommand('set foreign_key_checks=0')->execute();
          
              foreach ($data as $request)
              {    
                          $newRequest = new Restore_request();    
                          $newRequest->request_id = $request['request_old_id'];
                          $newRequest->request_ref_num = $request['request_ref_num'];
                          $newRequest->request_datetime= $request['request_datetime'];
                          $newRequest->rstl_id= $request['rstl_id'];
                          $newRequest->lab_id= $request['lab_id'];
                          $newRequest->customer_id= $request['customer_id'];
                          $newRequest->payment_type_id= $request['payment_type_id'];
                          $newRequest->modeofrelease_ids= $request['modeofrelease_ids'];
                          $newRequest->discount = $request['discount'];
                          $newRequest->purpose_id= $request['purpose_id'];
                          $newRequest->conforme= $request['conforme'];
                          $newRequest->report_due= $request['report_due'];
                          $newRequest->total = $request['total'];
                          $newRequest->receivedBy = $request['receivedBy'];
                          $newRequest->recommended_due_date = $request['recommended_due_date'];
                          $newRequest->est_date_completion = $request['est_date_completion'];
                          $newRequest->items_receive_by = $request['items_receive_by'];
                          $newRequest->equipment_release_date = $request['equipment_release_date'];
                          $newRequest->certificate_release_date = $request['certificate_release_date'];
                          $newRequest->released_by = $request['released_by'];
                          $newRequest->posted = $request['posted'];
                          $newRequest->status_id = $request['status_id'];
                          $newRequest->selected = $request['selected'];
                          $newRequest->other_fees_id = $request['other_fees_id'];
                          $newRequest->request_type_id = $request['request_type_id'];
                          $newRequest->position = $request['position'];
                          $newRequest->completed = $request['completed'];
                          $newRequest->received_by = $request['received_by'];
                          $newRequest->payment_status_id = $request['payment_status_id'];
                          $newRequest->oldColumn_requestId= $request['oldColumn_requestId'];
                          $newRequest->oldColumn_sublabId= $request['oldColumn_sublabId'];
                          $newRequest->oldColumn_orId = $request['oldColumn_orId'];
                          $newRequest->oldColumn_completed= $request['oldColumn_completed'];
                          $newRequest->oldColumn_cancelled= $request['oldColumn_cancelled'];
                          $newRequest->oldColumn_create_time= $request['oldColumn_create_time'];
                          $newRequest->request_old_id= $request['request_old_id'];
                          $newRequest->created_at= $request['created_at'];
                          $newRequest->discount_id= $request['discount_id'];
                          $newRequest->customer_old_id= $request['customer_old_id'];
                          $newRequest->tmpCustomerID= $request['tmpCustomerID'];
                          $newRequest->save();
                          $request_count++;
                          
                          foreach ($request['sample'] as $samp){
                              $sample_count++;          
                              $newSample = new Restore_sample();
                              $newSample->rstl_id=$samp['rstl_id'];
                            //   $newSample->sample_id=$samp['sample_old_id'];
                              $newSample->pstcsample_id=$samp['pstcsample_id'];
                              $newSample->sampletype_id=$samp['sampletype_id'];
                              $newSample->package_id=$samp['package_id'];
                              $newSample->package_rate=$samp['package_rate'];
                              $newSample->sample_code=$samp['sample_code'];
                              $newSample->samplename=$samp['samplename'];
                              $newSample->description=$samp['description'];
                              $sampdate = $samp['sampling_date'];        
                                    if ($sampdate=="0000-00-00 00:00:00"){
                                            $newSample->sampling_date=null;
                                    }else{
                                            $newSample->sampling_date=$sampdate;
                                    }                        
                              $newSample->remarks=$samp['remarks'];
                              $newSample->request_id=$newRequest['request_id'];
                              $newSample->sample_month=$samp['sample_month'];
                              $newSample->sample_year=$samp['sample_year'];
                              $newSample->active=$samp['active'];
                              $newSample->sample_old_id=$samp['sample_old_id'];
                              $newSample->oldColumn_requestId=$samp['oldColumn_requestId'];
                              $newSample->oldColumn_completed=$samp['oldColumn_completed'];
                              if ($datedisposed="0000-00-00"){
                                $newSample->oldColumn_datedisposal=null;
                              }else{
                                $newSample->oldColumn_datedisposal=$datedisposed;
                              }
                              $newSample->oldColumn_mannerofdisposal=$samp['oldColumn_mannerofdisposal'];
                              $newSample->oldColumn_batch_num=$samp['oldColumn_batch_num'];
                              $newSample->oldColumn_package_count=$samp['oldColumn_package_count'];
                              $newSample->testcategory_id=$samp['testcategory_id'];
                              $newSample->save(true); 
                        foreach ($samp['analyses'] as $anals){
                            $analysis_count++;
                            $newanalysis = new Restore_analysis();
                           // $newanalysis->analysis_id=$anals['analysis_old_id'];
                            $newanalysis->rstl_id=$anals['rstl_id'];
                            $newanalysis->pstcanalysis_id=$anals['pstcanalysis_id'];
                            $newanalysis->sample_id =$anals['sample_id'];
                            $newanalysis->sample_code=$anals['sample_code'];
                            $newanalysis->testname=$anals['testname'];
                            $newanalysis->method=$anals['method'];
                            $newanalysis->references=$anals['references'];
                            $newanalysis->quantity=$anals['quantity'];
                            $newanalysis->fee=$anals['fee'];
                            $newanalysis->test_id=$anals['test_id'];
                            $newanalysis->cancelled=$anals['cancelled'];
                            $newanalysis->date_analysis=$anals['date_analysis'];
                            $newanalysis->user_id=$anals['user_id'];
                            $newanalysis->is_package=$anals['is_package'];
                            $newanalysis->oldColumn_deleted=$anals['oldColumn_deleted'];
                            $newanalysis->analysis_old_id=$anals['analysis_old_id'];
                            $newanalysis->oldColumn_taggingId=$anals['oldColumn_taggingId'];
                            $newanalysis->oldColumn_result=$anals['oldColumn_result'];
                            $newanalysis->oldColumn_package_count=$anals['oldColumn_package_count'];
                            $newanalysis->oldColumn_requestId=$anals['oldColumn_requestId'];
                            $newanalysis->request_id =  43;
                            $newanalysis->testcategory_id=$anals['testcategory_id'];
                            $newanalysis->sample_type_id=$anals['sample_type_id'];
                            $newanalysis->old_sample_id=$anals['old_sample_id'];
                            $newanalysis->save(true); 

                            foreach ($request['customer'] as $customer){
                                $newcustomer = new Restore_customer();
                                $cus = Customer::find()->where(['customer_id'=>  $customer['customer_id']])->all();
                                if ($cus){
                                    
                                }else{
                                    $newcustomer->customer_id = $customer['customer_id'];
                                    $newcustomer->rstl_id = $customer['rstl_id'];
                                    $newcustomer->customer_code = $customer['customer_code'];
                                    $newcustomer->customer_name = $customer['customer_name'];
                                    $newcustomer->classification_id = $customer['classification_id'];
                                    $newcustomer->latitude = $customer['latitude'];
                                    $newcustomer->longitude = $customer['longitude'];
                                    $newcustomer->head = $customer['head'];
                                    $newcustomer->barangay_id = $customer['barangay_id'];
                                    $newcustomer->address = $customer['address'];
                                    $newcustomer->tel = $customer['tel'];
                                    $newcustomer->fax = $customer['fax'];
                                    $newcustomer->email = $customer['email'];
                                    $newcustomer->customer_type_id = $customer['customer_type_id'];
                                    $newcustomer->business_nature_id = $customer['business_nature_id'];
                                    $newcustomer->industrytype_id = $customer['industrytype_id'];
                                    $newcustomer->created_at = $customer['created_at'];
                                    $newcustomer->customer_old_id = $customer['customer_old_id'];
                                    $newcustomer->Oldcolumn_municipalitycity_id = $customer['Oldcolumn_municipalitycity_id'];
                                    $newcustomer->Oldcolumn_district = $customer['Oldcolumn_district'];
                                    $newcustomer->local_customer_id = $customer['local_customer_id'];
                                    $newcustomer->is_sync_up = $customer['is_sync_up'];
                                    $newcustomer->is_updated = $customer['is_updated'];
                                    $newcustomer->is_deleted = $customer['is_deleted'];
                                    $newcustomer->save(false);
                                }
                              }                 
                        }
                    }
                    $samplenum = $samplenum + $request['countSample'];
                    $analysesnum = $analysesnum + $request['countAnalysis'];             
                }
        
                    Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$year); 
                    $transaction->commit();
                    
                    $sql = "SET FOREIGN_KEY_CHECKS = 1;";


                    $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                    $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/countmax?rstl_id=".$GLOBALS['rstl_id']."&reqds=".$year."&reqde=".$year;
                    $curl = curl_init();			
                    curl_setopt($curl, CURLOPT_URL, $apiUrl);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
                    curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($curl);			
                    $data = json_decode($response, true);   
                    
                    $model->activity = "Restored data for the year ".$year;
                    $model->date = date('Y-M-d');
                    $model->data = $request_count."/".$request_count;
                    $model->status = "COMPLETED";
                    $model->month = $sample_count."/".$samplenum;
                    $model->monthyear = $month_value.$year;
                    $model->last_num = $data['last_request_id'];
                 
                    $model->year = $analysis_count."/".$analysis_count;
                    Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$year); 
                    $model->save(false);
         }     
        $message = "Data has been successfully restored.";
        return Json::encode([
            'message'=>$message,    
        ]);
        exit;
              return $this->renderAjax('/lab/backup_restore', [
                 'model'=>$model,
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]);  
     }

     public function actionRestoreyear(){
        //by year	

       $year =  $_POST['year'];

       for($month=1;$month < 13;$month++){

           if ($month>9){
               $start = $year."-".$month;
               $end = $year."-".$month;
           }else{
               $start = $year."-"."0".$month;
               $end = $year."-"."0".$month;
           }
                
           $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
           $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&reqds=".$start."&reqde=".$end;
               
           $curl = curl_init();                   
           curl_setopt($curl, CURLOPT_URL, $apiUrl);
           curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
           curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
           curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
           $response = curl_exec($curl);
               
           $data = json_decode($response, true);
            
           $sql = "SET FOREIGN_KEY_CHECKS = 0;";
           $connection = Yii::$app->labdb;
           
          

           $transaction = $connection->beginTransaction();
           $connection->createCommand('set foreign_key_checks=0')->execute();
         
             foreach ($data as $request)
             {    
                        $newRequest = new Restore_request();    
                        $newRequest->request_id = $request['request_old_id'];
                    //  $newRequest->request_id = $request['request_id'];
                        $newRequest->request_ref_num = $request['request_ref_num'];
                        $newRequest->request_datetime= $request['request_datetime'];
                        $newRequest->rstl_id= $request['rstl_id'];
                        $newRequest->lab_id= $request['lab_id'];
                        $newRequest->customer_id= $request['customer_id'];
                        $newRequest->payment_type_id= $request['payment_type_id'];
                        $newRequest->modeofrelease_ids= $request['modeofrelease_ids'];
                        $newRequest->discount = $request['discount'];
                        $newRequest->purpose_id= $request['purpose_id'];
                        $newRequest->conforme= $request['conforme'];
                        $newRequest->report_due= $request['report_due'];
                        $newRequest->total = $request['total'];
                        $newRequest->receivedBy = $request['receivedBy'];
                        $newRequest->recommended_due_date = $request['recommended_due_date'];
                        $newRequest->est_date_completion = $request['est_date_completion'];
                        $newRequest->items_receive_by = $request['items_receive_by'];
                        $newRequest->equipment_release_date = $request['equipment_release_date'];
                        $newRequest->certificate_release_date = $request['certificate_release_date'];
                        $newRequest->released_by = $request['released_by'];
                        $newRequest->posted = $request['posted'];
                        $newRequest->status_id = $request['status_id'];
                        $newRequest->selected = $request['selected'];
                        $newRequest->other_fees_id = $request['other_fees_id'];
                        $newRequest->request_type_id = $request['request_type_id'];
                        $newRequest->position = $request['position'];
                        $newRequest->completed = $request['completed'];
                        $newRequest->received_by = $request['received_by'];
                        $newRequest->payment_status_id = $request['payment_status_id'];
                        $newRequest->oldColumn_requestId= $request['oldColumn_requestId'];
                        $newRequest->oldColumn_sublabId= $request['oldColumn_sublabId'];
                        $newRequest->oldColumn_orId = $request['oldColumn_orId'];
                        $newRequest->oldColumn_completed= $request['oldColumn_completed'];
                        $newRequest->oldColumn_cancelled= $request['oldColumn_cancelled'];
                        $newRequest->oldColumn_create_time= $request['oldColumn_create_time'];
                        $newRequest->request_old_id= $request['request_old_id'];
                        $newRequest->created_at= $request['created_at'];
                        $newRequest->discount_id= $request['discount_id'];
                        $newRequest->customer_old_id= $request['customer_old_id'];
                        $newRequest->tmpCustomerID= $request['tmpCustomerID'];
                        $newRequest->save();
                         $request_count++;
                         
                         foreach ($request['sample'] as $samp){
                             $sample_count++;          
                             $newSample = new Restore_sample();
                             $newSample->rstl_id=$samp['rstl_id'];
                            // $newSample->sample_id=$samp['sample_old_id'];
                             $newSample->sample_id=$samp['sample_id'];
                             $newSample->pstcsample_id=$samp['pstcsample_id'];
                             $newSample->sampletype_id=$samp['sampletype_id'];
                             $newSample->package_id=$samp['package_id'];
                             $newSample->package_rate=$samp['package_rate'];
                             $newSample->sample_code=$samp['sample_code'];
                             $newSample->samplename=$samp['samplename'];
                             $newSample->description=$samp['description'];
                              $sampdate = $samp['sampling_date'];
   
                             if ($sampdate=="0000-00-00 00:00:00"){
                               $newSample->sampling_date=null;
                             }else{
                               $newSample->sampling_date=$sampdate;
                             }
                             
                             $newSample->remarks=$samp['remarks'];
                             $newSample->request_id=$newRequest['request_id'];
                             //$newSample->request_id=$samp['old_request_id'];
                             $newSample->sample_month=$samp['sample_month'];
                             $newSample->sample_year=$samp['sample_year'];
                             $newSample->active=$samp['active'];
                             $newSample->sample_old_id=$samp['sample_old_id'];
                             $newSample->oldColumn_requestId=$samp['oldColumn_requestId'];
                             $newSample->oldColumn_completed=$samp['oldColumn_completed'];
                             $datedisposed = $samp['oldColumn_datedisposal'];
   
                             if ($datedisposed="0000-00-00"){
                               $newSample->oldColumn_datedisposal=null;
                             }else{
                               $newSample->oldColumn_datedisposal=$datedisposed;
                             }
                            
                             $newSample->oldColumn_mannerofdisposal=$samp['oldColumn_mannerofdisposal'];
                             $newSample->oldColumn_batch_num=$samp['oldColumn_batch_num'];
                             $newSample->oldColumn_package_count=$samp['oldColumn_package_count'];
                             $newSample->testcategory_id=$samp['testcategory_id'];
                             $newSample->save(true); 
                       foreach ($samp['analyses'] as $anals){
                           $analysis_count++;
                           $newanalysis = new Restore_analysis();
                           //  $newanalysis->analysis_id=$anals['analysis_old_id'];
                           //  $newanalysis->analysis_id=$anals['analysis_id'];
                             $newanalysis->rstl_id=$anals['rstl_id'];
                             $newanalysis->pstcanalysis_id=$anals['pstcanalysis_id'];
                             $newanalysis->sample_id =$newSample['sample_id'];
                            // $newanalysis->sample_id =$anals['old_sample_id'];
                             $newanalysis->sample_code=$anals['sample_code'];
                             $newanalysis->testname=$anals['testname'];
                             $newanalysis->method=$anals['method'];
                             $newanalysis->references=$anals['references'];
                             $newanalysis->quantity=$anals['quantity'];
                             $newanalysis->fee=$anals['fee'];
                             $newanalysis->test_id=$anals['test_id'];
                             $newanalysis->cancelled=$anals['cancelled'];
                             $newanalysis->date_analysis=$anals['date_analysis'];
                             $newanalysis->user_id=$anals['user_id'];
                             $newanalysis->is_package=$anals['is_package'];
                             $newanalysis->oldColumn_deleted=$anals['oldColumn_deleted'];
                             $newanalysis->analysis_old_id=$anals['analysis_old_id'];
                             $newanalysis->oldColumn_taggingId=$anals['oldColumn_taggingId'];
                             $newanalysis->oldColumn_result=$anals['oldColumn_result'];
                             $newanalysis->oldColumn_package_count=$anals['oldColumn_package_count'];
                             $newanalysis->oldColumn_requestId=$anals['oldColumn_requestId'];
                             $newanalysis->request_id =  43;
                             $newanalysis->testcategory_id=$anals['testcategory_id'];
                             $newanalysis->sample_type_id=$anals['sample_type_id'];
                             $newanalysis->old_sample_id=$anals['old_sample_id'];
                             $newanalysis->save(true);	

                           foreach ($request['customer'] as $customer){
                               $newcustomer = new Restore_customer();
                               $cus = Customer::find()->where(['customer_id'=>  $customer['customer_id']])->all();
                               if ($cus){
                                   
                               }else{
                                   $newcustomer->customer_id = $customer['customer_id'];
                                   $newcustomer->rstl_id = $customer['rstl_id'];
                                   $newcustomer->customer_code = $customer['customer_code'];
                                   $newcustomer->customer_name = $customer['customer_name'];
                                   $newcustomer->classification_id = $customer['classification_id'];
                                   $newcustomer->latitude = $customer['latitude'];
                                   $newcustomer->longitude = $customer['longitude'];
                                   $newcustomer->head = $customer['head'];
                                   $newcustomer->barangay_id = $customer['barangay_id'];
                                   $newcustomer->address = $customer['address'];
                                   $newcustomer->tel = $customer['tel'];
                                   $newcustomer->fax = $customer['fax'];
                                   $newcustomer->email = $customer['email'];
                                   $newcustomer->customer_type_id = $customer['customer_type_id'];
                                   $newcustomer->business_nature_id = $customer['business_nature_id'];
                                   $newcustomer->industrytype_id = $customer['industrytype_id'];
                                   $newcustomer->created_at = $customer['created_at'];
                                   $newcustomer->customer_old_id = $customer['customer_old_id'];
                                   $newcustomer->Oldcolumn_municipalitycity_id = $customer['Oldcolumn_municipalitycity_id'];
                                   $newcustomer->Oldcolumn_district = $customer['Oldcolumn_district'];
                                   $newcustomer->local_customer_id = $customer['local_customer_id'];
                                   $newcustomer->is_sync_up = $customer['is_sync_up'];
                                   $newcustomer->is_updated = $customer['is_updated'];
                                   $newcustomer->is_deleted = $customer['is_deleted'];
                                   $newcustomer->save(false);
                               }
                             }                 
                       }
                   }
               
               }
       
                   Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$year); 
                   $transaction->commit();
                   
                   $sql = "SET FOREIGN_KEY_CHECKS = 1;";

                  //dapat mag save ito somewhere
                   $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                   $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/countmax?rstl_id=".$GLOBALS['rstl_id']."&reqds=".$year."&reqde=".$year;
                   $curl = curl_init();			
                   curl_setopt($curl, CURLOPT_URL, $apiUrl);
                   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                   curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
                   curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                   $response = curl_exec($curl);			
                   $data = json_decode($response, true);   
                   
        
                   Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$year); 
                  
        }     
       $message = "Data has been successfully restored.";
       return Json::encode([
           'message'=>$message,    
       ]);
       exit;
             return $this->renderAjax('/lab/backup_restore', [
                'model'=>$model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);  
    }

     public function actionResyear(){	 
        //by month

		$searchModel = new BackuprestoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Backuprestore();
        	 
        $month = $_POST['month'];
        $year =  $_POST['year'];
            
         if ($month=="January"){
            $month_value = "01";
        }elseif ($month=="February"){
            $month_value = "02";
        }elseif ($month=="March"){
            $month_value = "03";
        }elseif ($month=="April"){
            $month_value = "04";
        }elseif ($month=="May"){
            $month_value = "05";
        }elseif ($month=="June"){
            $month_value = "06";
        }elseif ($month=="July"){
            $month_value = "07";
        }elseif ($month=="August"){
            $month_value = "08";
        }elseif($month=="September"){
            $month_value = "09";
        }elseif($month=="October"){
            $month_value = "10";
        }elseif ($month=="November"){
            $month_value = "11";
        }elseif ($month=="December"){
            $month_value = "12";
        }
        $br = Backuprestore::find()->where([ 'monthyear'=> $month_value.$year])->one();

       if ($br) {
            $message = "The month you have selected has been succesfully restored.";
            return Json::encode([
                'message'=>$message,          
            ]);
            exit;
            }

        $start = $year."-".$month_value;
        $end = $year."-".$month_value;
		
        $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

        $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&reqds=".$start."&reqde=".$end;
            
        $curl = curl_init();
				
		curl_setopt($curl, CURLOPT_URL, $apiUrl);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
		curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($curl);
			
		$data = json_decode($response, true);
		  
       
        $sql = "SET FOREIGN_KEY_CHECKS = 0;";
        $connection = Yii::$app->labdb;
        
        $request_count = 0;
        $sample_count = 0;
        $analysis_count = 0;
		$samplenum = 0;
		$analysesnum = 0;

		$transaction = $connection->beginTransaction();
		$connection->createCommand('set foreign_key_checks=0')->execute();
    
          foreach ($data as $request)
          {    
                      $newRequest = new Restore_request();    
                      $newRequest->request_id = $request['request_old_id'];
                    //  $newRequest->request_id = $request['request_id'];
                      $newRequest->request_ref_num = $request['request_ref_num'];
                      $newRequest->request_datetime= $request['request_datetime'];
                      $newRequest->rstl_id= $request['rstl_id'];
                      $newRequest->lab_id= $request['lab_id'];
                      $newRequest->customer_id= $request['customer_id'];
                      $newRequest->payment_type_id= $request['payment_type_id'];
                      $newRequest->modeofrelease_ids= $request['modeofrelease_ids'];
                      $newRequest->discount = $request['discount'];
                      $newRequest->purpose_id= $request['purpose_id'];
                      $newRequest->conforme= $request['conforme'];
                      $newRequest->report_due= $request['report_due'];
                      $newRequest->total = $request['total'];
                      $newRequest->receivedBy = $request['receivedBy'];
                      $newRequest->recommended_due_date = $request['recommended_due_date'];
                      $newRequest->est_date_completion = $request['est_date_completion'];
                      $newRequest->items_receive_by = $request['items_receive_by'];
                      $newRequest->equipment_release_date = $request['equipment_release_date'];
                      $newRequest->certificate_release_date = $request['certificate_release_date'];
                      $newRequest->released_by = $request['released_by'];
                      $newRequest->posted = $request['posted'];
                      $newRequest->status_id = $request['status_id'];
                      $newRequest->selected = $request['selected'];
                      $newRequest->other_fees_id = $request['other_fees_id'];
                      $newRequest->request_type_id = $request['request_type_id'];
                      $newRequest->position = $request['position'];
                      $newRequest->completed = $request['completed'];
                      $newRequest->received_by = $request['received_by'];
                      $newRequest->payment_status_id = $request['payment_status_id'];
                      $newRequest->oldColumn_requestId= $request['oldColumn_requestId'];
                      $newRequest->oldColumn_sublabId= $request['oldColumn_sublabId'];
                      $newRequest->oldColumn_orId = $request['oldColumn_orId'];
                      $newRequest->oldColumn_completed= $request['oldColumn_completed'];
                      $newRequest->oldColumn_cancelled= $request['oldColumn_cancelled'];
                      $newRequest->oldColumn_create_time= $request['oldColumn_create_time'];
                      $newRequest->request_old_id= $request['request_old_id'];
                      $newRequest->created_at= $request['created_at'];
                      $newRequest->discount_id= $request['discount_id'];
                      $newRequest->customer_old_id= $request['customer_old_id'];
                      $newRequest->tmpCustomerID= $request['tmpCustomerID'];
                      $newRequest->save();
                      $request_count++;
					  
                      foreach ($request['sample'] as $samp){
                          $sample_count++;          
                          $newSample = new Restore_sample();
                          $newSample->rstl_id=$samp['rstl_id'];
                         // $newSample->sample_id=$samp['sample_old_id'];
                         // $newSample->sample_id=$samp['sample_id'];
                          $newSample->pstcsample_id=$samp['pstcsample_id'];
                          $newSample->sampletype_id=$samp['sampletype_id'];
                          $newSample->package_id=$samp['package_id'];
                          $newSample->package_rate=$samp['package_rate'];
                          $newSample->sample_code=$samp['sample_code'];
                          $newSample->samplename=$samp['samplename'];
                          $newSample->description=$samp['description'];
                           $sampdate = $samp['sampling_date'];

                          if ($sampdate=="0000-00-00 00:00:00"){
                            $newSample->sampling_date=null;
                          }else{
                            $newSample->sampling_date=$sampdate;
                          }
                          
                          $newSample->remarks=$samp['remarks'];
                          $newSample->request_id=$newRequest['request_id'];
                          //$newSample->request_id=$samp['old_request_id'];
                          $newSample->sample_month=$samp['sample_month'];
                          $newSample->sample_year=$samp['sample_year'];
                          $newSample->active=$samp['active'];
                          $newSample->sample_old_id=$samp['sample_old_id'];
                          $newSample->oldColumn_requestId=$samp['oldColumn_requestId'];
                          $newSample->oldColumn_completed=$samp['oldColumn_completed'];
                          $datedisposed = $samp['oldColumn_datedisposal'];

                          if ($datedisposed="0000-00-00"){
                            $newSample->oldColumn_datedisposal=null;
                          }else{
                            $newSample->oldColumn_datedisposal=$datedisposed;
                          }
                         
                          $newSample->oldColumn_mannerofdisposal=$samp['oldColumn_mannerofdisposal'];
                          $newSample->oldColumn_batch_num=$samp['oldColumn_batch_num'];
                          $newSample->oldColumn_package_count=$samp['oldColumn_package_count'];
                          $newSample->testcategory_id=$samp['testcategory_id'];
                          $newSample->save(true); 
             
					foreach ($samp['analyses'] as $anals){
						$analysis_count++;
						$newanalysis = new Restore_analysis();
                      //  $newanalysis->analysis_id=$anals['analysis_old_id'];
                      //  $newanalysis->analysis_id=$anals['analysis_id'];
						$newanalysis->rstl_id=$anals['rstl_id'];
						$newanalysis->pstcanalysis_id=$anals['pstcanalysis_id'];
                        $newanalysis->sample_id =$newSample['sample_id'];
                       // $newanalysis->sample_id =$anals['old_sample_id'];
						$newanalysis->sample_code=$anals['sample_code'];
						$newanalysis->testname=$anals['testname'];
						$newanalysis->method=$anals['method'];
						$newanalysis->references=$anals['references'];
						$newanalysis->quantity=$anals['quantity'];
						$newanalysis->fee=$anals['fee'];
						$newanalysis->test_id=$anals['test_id'];
						$newanalysis->cancelled=$anals['cancelled'];
						$newanalysis->date_analysis=$anals['date_analysis'];
						$newanalysis->user_id=$anals['user_id'];
						$newanalysis->is_package=$anals['is_package'];
						$newanalysis->oldColumn_deleted=$anals['oldColumn_deleted'];
						$newanalysis->analysis_old_id=$anals['analysis_old_id'];
						$newanalysis->oldColumn_taggingId=$anals['oldColumn_taggingId'];
						$newanalysis->oldColumn_result=$anals['oldColumn_result'];
						$newanalysis->oldColumn_package_count=$anals['oldColumn_package_count'];
						$newanalysis->oldColumn_requestId=$anals['oldColumn_requestId'];
						$newanalysis->request_id =  43;
						$newanalysis->testcategory_id=$anals['testcategory_id'];
						$newanalysis->sample_type_id=$anals['sample_type_id'];
						$newanalysis->old_sample_id=$anals['old_sample_id'];
                        $newanalysis->save(true);	
                        
                        foreach ($request['customer'] as $customer){
                            $newcustomer = new Restore_customer();
                            $cus = Customer::find()->where(['customer_id'=>  $customer['customer_id']])->all();
                            if ($cus){
                                
                            }else{
                                $newcustomer->customer_id = $customer['customer_id'];
                                $newcustomer->rstl_id = $customer['rstl_id'];
                                $newcustomer->customer_code = $customer['customer_code'];
                                $newcustomer->customer_name = $customer['customer_name'];
                                $newcustomer->classification_id = $customer['classification_id'];
                                $newcustomer->latitude = $customer['latitude'];
                                $newcustomer->longitude = $customer['longitude'];
                                $newcustomer->head = $customer['head'];
                                $newcustomer->barangay_id = $customer['barangay_id'];
                                $newcustomer->address = $customer['address'];
                                $newcustomer->tel = $customer['tel'];
                                $newcustomer->fax = $customer['fax'];
                                $newcustomer->email = $customer['email'];
                                $newcustomer->customer_type_id = $customer['customer_type_id'];
                                $newcustomer->business_nature_id = $customer['business_nature_id'];
                                $newcustomer->industrytype_id = $customer['industrytype_id'];
                                $newcustomer->created_at = $customer['created_at'];
                                $newcustomer->customer_old_id = $customer['customer_old_id'];
                                $newcustomer->Oldcolumn_municipalitycity_id = $customer['Oldcolumn_municipalitycity_id'];
                                $newcustomer->Oldcolumn_district = $customer['Oldcolumn_district'];
                                $newcustomer->local_customer_id = $customer['local_customer_id'];
                                $newcustomer->is_sync_up = $customer['is_sync_up'];
                                $newcustomer->is_updated = $customer['is_updated'];
                                $newcustomer->is_deleted = $customer['is_deleted'];
                                $newcustomer->save(false);
                         }
                      }
                   }
				}
				$samplenum = $samplenum + $request['countSample'];
				$analysesnum = $analysesnum + $request['countAnalysis'];			
            }
	
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$month.' '.$year); 
                $transaction->commit();
				
                $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                

                $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restoresync?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&reqds=".$start."&reqde=".$end;        
                $curl = curl_init();			
                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
                curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);			
                $data = json_decode($response, true);      
                //echo $data['last_request_id'];
                
				$model->activity = "Restored data for the month of ".$month."-".$year;
                $model->date = date('Y-M-d');
                $model->customer = 1;
				$model->data = count($data)."/".$request_count;
				$model->status = "COMPLETED";
                $model->month = $sample_count."/".$samplenum;
                $model->monthyear = $month_value.$year;
                $model->last_num = $data['last_request_id'];
			
                $model->year = $analysis_count."/".$analysesnum;
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$month.' '.$year); 
				$model->save(false);
		
	
        $message = "Data has been successfully restored.";
        return Json::encode([
            'message'=>$message,
        
        ]);
        exit;
              return $this->renderAjax('/lab/backup_restore', [
                 'model'=>$model,
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]);
     
     }


    public function actionCustomer()
    {
        return $this->render('customers');
    }
}