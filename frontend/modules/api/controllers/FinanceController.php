<?php 

namespace frontend\modules\api\controllers;

use yii\web\Controller;
use Yii;
use linslin\yii2\curl;
use common\models\finance\Restore_op;
use common\models\finance\Restore_paymentitem;
use common\models\finance\SubsidiaryCustomer;
use common\models\finance\BackuprestoreLogs;
use common\models\finance\BackuprestoreLogsSearch;
use yii\helpers\Json;
use common\models\finance\Restore_receipt;
use common\models\finance\Restore_deposit;
use common\models\finance\Restore_check;

use common\models\finance\Op;
use common\models\finance\Paymentitem;
use common\models\finance\Receipt;
use common\models\finance\Deposit;
use common\models\finance\Check;
set_time_limit(10000);

/**
 * Default controller for the `Lab` module
 */
class FinanceController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
     public function actionIndex()
     {
         $searchModel = new BackuprestoreLogsSearch();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         $model = new BackuprestoreLogs();
         
        $op = Op::find()->count();
        $paymentitem = Paymentitem::find()->count();
        $receipt = Receipt::find()->count();
        $deposit= Deposit::find()->count();
        $check=Check::find()->count();

        $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
        $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/ops/countop?rstl_id=".$GLOBALS['rstl_id'];        
        $curl = curl_init();			
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);			
        $data = json_decode($response, true);

        //paymentitem
        $apiUrl_paymentitem="https://eulimsapi.onelab.ph/api/web/v1/paymentitems/countpaymentitem?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_paymentitem = curl_init();			
        curl_setopt($curl_paymentitem, CURLOPT_URL, $apiUrl_paymentitem);
        curl_setopt($curl_paymentitem, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_paymentitem, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_paymentitem, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_paymentitem, CURLOPT_RETURNTRANSFER, true);
        $response_paymentitem = curl_exec($curl_paymentitem);			
        $data_paymentitem = json_decode($response_paymentitem, true);

        //receipt
        $apiUrl_receipt="https://eulimsapi.onelab.ph/api/web/v1/receipts/countreceipt?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_receipt = curl_init();			
        curl_setopt($curl_receipt, CURLOPT_URL, $apiUrl_receipt);
        curl_setopt($curl_receipt, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_receipt, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_receipt, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_receipt, CURLOPT_RETURNTRANSFER, true);
        $response_receipt = curl_exec($curl_receipt);			
        $data_receipt = json_decode($response_receipt, true);
        
        //deposit
        $apiUrl_deposit="https://eulimsapi.onelab.ph/api/web/v1/deposits/countdeposit?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_deposit = curl_init();			
        curl_setopt($curl_deposit, CURLOPT_URL, $apiUrl_deposit);
        curl_setopt($curl_deposit, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_deposit, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_deposit, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_deposit, CURLOPT_RETURNTRANSFER, true);
        $response_deposit = curl_exec($curl_deposit);			
        $data_deposit = json_decode($response_deposit, true);
        
        //check
        $apiUrl_check="https://eulimsapi.onelab.ph/api/web/v1/checks/countcheck?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_check = curl_init();			
        curl_setopt($curl_check, CURLOPT_URL, $apiUrl_check);
        curl_setopt($curl_check, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_check, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_check, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_check, CURLOPT_RETURNTRANSFER, true);
        $response_check = curl_exec($curl_check);			
        $data_check = json_decode($response_check, true);
        
        $opdata=number_format($op)."/ ".number_format($data);
        
        $paymentitemdata=number_format($paymentitem)."/ ".number_format($data_paymentitem);
        
        $receiptdata=number_format($receipt)."/ ".number_format($data_receipt);
        
        $depositdata=number_format($deposit)."/ ".number_format($data_deposit);
        $checkdata=number_format($check)."/ ".number_format($data_check);
        
         return $this->render('backup_restore', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
             'model'=>$model,
             'op'=>$opdata,
             'paymentitem'=> $paymentitemdata, 
             'receipt'=> $receiptdata, 
             'deposit'=> $depositdata,
             'check' => $checkdata
         ]);
     }
     public function actionRessync(){
       $year =  $_POST['year']; 
      $this->actionRes($year);
     $this->actionRes_deposit($year);
       ////// $this->actionRes_paymentitem();
        $this->actionRes_receipt($year);
       
        return $this->redirect('/api/finance');
     }
     public function actionRes($year){
	//$month = (int)$_POST['month'] + 1;
        //$year =  $_POST['year'];
        
        for($month=1;$month < 13;$month++){
       // for($month=12;$month > 0;$month--){  
            $month_value=str_pad($month,2,"0",STR_PAD_LEFT);
            $start = $year."-".$month_value;
            $end = $year."-".$month_value;

            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

            $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/ops/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&opds=".$start."&opde=".$end;



            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            $data = json_decode($response, true);
            //var_dump($data);exit;
            if($data){
                 $sql = "SET FOREIGN_KEY_CHECKS = 0;";


                $op_count = 0;
                $paymentitem_count = 0;
                $op_sc=0;
                $receipt_count = 0;
                $deposit_count = 0;
                $check_count=0;
                $connection= Yii::$app->financedb;
                $transaction = $connection->beginTransaction();
                $connection->createCommand('set foreign_key_checks=0')->execute();
                

                try {
                 foreach ($data as $op)
                 {    

                        $newOp = new Restore_op();  

                        $newOp->orderofpayment_id= $op['orderofpayment_id'];

                        $newOp->rstl_id= $op['rstl_id'];

                        $newOp->transactionnum= $op['transactionnum'];
                        $newOp->collectiontype_id= $op['collectiontype_id'];
                        $newOp->payment_mode_id= $op['payment_mode_id'];
                        $newOp->on_account= $op['on_account'];
                        $newOp->order_date= $op['order_date'];
                        $newOp->customer_id= $op['customer_id'];
                        $newOp->receipt_id=$op['receipt_id'];
                        $newOp->purpose= $op['purpose'];
                        $newOp->payment_status_id= $op['payment_status_id'];
                        $newOp->save();
                        $op_count++;

                        foreach ($op['paymentitems'] as $item){

                            $paymentitem_count++;          
                            $newPaymentitem = new Restore_paymentitem();
                            $newPaymentitem->paymentitem_id= $item['paymentitem_id'];
                            $newPaymentitem->rstl_id=$item['rstl_id'];
                            $newPaymentitem->request_id=$item['request_id'];
                            $newPaymentitem->request_type_id=$item['request_type_id'];
                            $newPaymentitem->orderofpayment_id=$newOp->orderofpayment_id;
                            $newPaymentitem->details=$item['details'];
                            $newPaymentitem->amount=$item['amount'];
                            $newPaymentitem->cancelled=$item['cancelled'];
                            $newPaymentitem->status=$item['status'];
                            $newPaymentitem->receipt_id=$item['receipt_id'];
                            $newPaymentitem->save(); 
                        }
                        

                 } 


                    $model = new BackuprestoreLogs();

                    $model->activity = "Restored data for the month of ".$month."-".$year;
                    $model->transaction_date = date('Y-M-d');
                    $model->data_date=$month."-".$year;
                    $model->op = count($data)."/".$op_count; 
                    $model->paymentitem = $paymentitem_count."/".$paymentitem_count;
                    $model->status = "COMPLETED";
                    $model->save();

                    $transaction->commit();

                    $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                    Yii::$app->session->setFlash('success', ' Records Successfully Restored for the year '.$year); 

                }catch (\Exception $e) {
                    Yii::$app->session->setFlash('warning', $e->getMessage()); 

                    $transaction->rollBack();
                }catch (\Throwable $e) {
                    Yii::$app->session->setFlash('warning', $e->getMessage()); 
                    $transaction->rollBack();

                }
            }        
           	
        }
       
	
       
        //return $this->redirect('/api/finance');
     
     }

    public function actionCustomer()
    {
        return $this->render('customers');
    }
    
    public function actionRes_receiptxxx($year){
      
        //$year =  $_POST['year'];
      
        $month=12;
        while($month > 0){
            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
            $apicom=Yii::$app->components['api_config'];
            
            if($year == "0000"){
              $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/receipts/restore?rstl_id=11&opds=0000-00-00&opde=00-00-00";
            }
            else{
                $month_value=str_pad($month,2,"0",STR_PAD_LEFT);
                $start = $year."-".$month_value."-"."01";
                $end = $year."-".$month_value."-"."31";
                //echo $start;
                //echo $end;
               // exit;
                $apiUrl=$apicom['api_url']."receipts/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&opds=".$start."&opde=".$end;
                 
            }
            
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            $data = json_decode($response, true);

            $sql = "SET FOREIGN_KEY_CHECKS = 0;";


            $receipt_count = 0;
            $deposit_count = 0;
            $check_count=0;

            $connection= Yii::$app->financedb;
            $transaction = $connection->beginTransaction();
            $connection->createCommand('set foreign_key_checks=0')->execute();
           //  echo"<pre>";var_dump($data); echo"</pre>";exit;
          
            try {
             foreach ($data as $receipt)
             {     
                    
                    $newReceipt = new Restore_receipt(); 
                    
                    //$newReceipt->receipt_id=$receipt['receipt_id'];
                    $newReceipt->receipt_id=$receipt['receipt_id'];
                    $newReceipt->rstl_id=$receipt['rstl_id'];
                    $newReceipt->orderofpayment_id=$receipt['orderofpayment_id'];
                    $newReceipt->deposit_type_id=$receipt['deposit_type_id'];
                    $newReceipt->or_series_id=$receipt['or_series_id'];
                    $newReceipt->or_number=$receipt['or_number'];
                    $newReceipt->receiptDate=$receipt['receiptDate'];
                    $newReceipt->payment_mode_id=$receipt['payment_mode_id'];
                    $newReceipt->payor=$receipt['payor'];
                    $newReceipt->collectiontype_id=$receipt['collectiontype_id'];
                    $newReceipt->total=$receipt['total'];
                    $newReceipt->deposit_id=$receipt['local_deposit_id'];
                    $newReceipt->customer_id=$receipt['customer_id'];
                    $newReceipt->terminal_id=1;
                    $newReceipt->cancelled=0;
                   
                   
                    $newReceipt->save(false);
                    $receipt_count++;
                    
                    foreach ($receipt['check'] as $item){
                           
                        $newCheck = new Restore_check();

                        $newCheck->check_id=$item['local_check_id'];
                        $newCheck->receipt_id=$item['receipt_id'];
                        $newCheck->bank=$item['bank'];
                        $newCheck->checknumber=$item['checknumber'];
                        $newCheck->checkdate=$item['checkdate'];
                        $newCheck->amount=$item['amount'];
                        $newCheck->rstl_id=$item['rstl_id'];
                        $newCheck->save(false); 
                             
                        $check_count++;    
                    }
                    
                        
             } 
            
                $transaction->commit();
                $dt=$month."-".$year;
          
                $model= BackuprestoreLogs::find()->where(['data_date'=>$dt])->one();
               
                if($model){
                    $model->receipt=$receipt_count;
                    $model->check=$check_count;  
                    $model->save(false);
                }else{
                    $model= new BackuprestoreLogs();
                    $model->activity = "Restored data for the month of ".$month."-".$year;
                    $model->transaction_date = date('Y-M-d');
                    $model->data_date=$month."-".$year;
                    $model->receipt=$receipt_count;
                    $model->check=$check_count;  
                    
                    $model->save(false);
                }
                $month--;
                
              //  $this->Res_deposit($year);
                $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for the year '.$year); 
                  
            }catch (\Exception $e) {
               // return $this->redirect('/api/finance');
                Yii::$app->session->setFlash('warning', $e->getMessage()); 

                $transaction->rollBack();
            }
        }
       
        //return $this->redirect('/api/finance');
     
     }
     
     public function actionRes_deposit($year){
         //$year =  $_POST['year'];
	
       //for($month=13;$month > 0;$month--){
        for($month=1;$month < 13;$month++){   
            $month_value=str_pad($month,2,"0",STR_PAD_LEFT);
            $start = $year."-".$month_value;
            $end = $year."-".$month_value;

            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

            $apicom=Yii::$app->components['api_config'];
            
            $apiUrl=$apicom['api_url']."deposits/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&opds=".$start."&opde=".$end;
            
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            $data = json_decode($response, true);
         
            $sql = "SET FOREIGN_KEY_CHECKS = 0;";


           
            $deposit_count = 0;
            

            $connection= Yii::$app->financedb;
            $transaction = $connection->beginTransaction();
            $connection->createCommand('set foreign_key_checks=0')->execute();
    
           // echo"<pre>".var_dump($data)."</pre>";exit;
            try {
                foreach ($data as $item){
                    
                    $newDeposit = new Restore_deposit();
                    $count=$this->findDeposit($item['local_deposit_id']);
                    
                    $newDeposit->deposit_id= $item['local_deposit_id'];
                    $newDeposit->rstl_id= $item['rstl_id'];
                    $newDeposit->or_series_id= $item['or_series_id'];
                    $newDeposit->start_or= $item['start_or'];
                    $newDeposit->end_or= $item['end_or'];
                    $newDeposit->amount= $item['amount'];
                    $newDeposit->deposit_type_id= $item['deposit_type_id'];
                    $newDeposit->deposit_date= $item['deposit_date'];
                    
                    if($count == 1){
                        
                    }else{ 
                        $newDeposit->save(); 
                        $deposit_count++;
                    }
                             
                              
                }
               
                $transaction->commit();
                
                $dt=$month."-".$year;
          
                $model= BackuprestoreLogs::find()->where(['data_date'=>$dt])->one();
                if($model){
                   $model->deposit = $deposit_count;
                   $model->save(false); 
                }else{
                   $model= new BackuprestoreLogs();
                   $model->activity = "Restored data for the month of ".$month."-".$year;
                    $model->transaction_date = date('Y-M-d');
                    $model->data_date=$month."-".$year;
                   $model->deposit = $deposit_count;
                   $model->save(false);
                }
                
                
                $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for the year '.$year); 
                  
            }catch (\Exception $e) {
                Yii::$app->session->setFlash('warning', $e->getMessage()); 

                $transaction->rollBack();
            }
        }
       
	
       
        //return $this->redirect('/api/finance');
     
     }
     
    public function findDeposit($depositid)
    {
        $dep = Deposit::find()->where(['deposit_id'=> $depositid])->count();
        return $dep;
    }
    public function findPaymentitem($paymentitemid)
    {
        $pi = Paymentitem::find()->where(['paymentitem_id'=> $paymentitemid])->count();
        return $pi;
    }
    
    public function actionRes_paymentitem(){
         
	
            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

            $apicom=Yii::$app->components['api_config'];
            
            $apiUrl=$apicom['api_url']."paymentitems/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id;
            
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            $data = json_decode($response, true);
          
            $sql = "SET FOREIGN_KEY_CHECKS = 0;";


           
            $paymentitem_count = 0;
            

            $connection= Yii::$app->financedb;
            $transaction = $connection->beginTransaction();
            $connection->createCommand('set foreign_key_checks=0')->execute();
    
            try {
                foreach ($data as $item){
                    $newPaymentitem = new Restore_paymentitem();
                    $id=$item['paymentitem_id'];
                    $count=$this->findPaymentitem($id);
                    
                    if($count > 0){
                        
                    }else{ 
                        $newPaymentitem->paymentitem_id= $item['paymentitem_id'];
                        $newPaymentitem->rstl_id=$item['rstl_id'];
                        $newPaymentitem->request_id=$item['request_id'];
                        $newPaymentitem->request_type_id=$item['request_type_id'];
                        $newPaymentitem->orderofpayment_id=0;
                        $newPaymentitem->details=$item['details'];
                        $newPaymentitem->amount=$item['amount'];
                        $newPaymentitem->cancelled=$item['cancelled'];
                        $newPaymentitem->status=$item['status'];
                        $newPaymentitem->receipt_id=$item['receipt_id'];
                        $newPaymentitem->save();
                        $paymentitem_count++;
                    }
                             
                              
                }
               
                $transaction->commit();
                
                
                $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for the year '); 
                  
            }catch (\Exception $e) {
                Yii::$app->session->setFlash('warning', $e->getMessage()); 

                $transaction->rollBack();
            }
        
       
	
       
        return $this->redirect('/api/finance');
     
     }
     
     public function actionSyncagain(){
        $op = Op::find()->count();
        $paymentitem = Paymentitem::find()->count();
        $receipt = Receipt::find()->count();
        $deposit= Deposit::find()->count();

        $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
        $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/ops/countop?rstl_id=".$GLOBALS['rstl_id'];        
        $curl = curl_init();			
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);			
        $data = json_decode($response, true);

        //paymentitem
        $apiUrl_paymentitem="https://eulimsapi.onelab.ph/api/web/v1/paymentitems/countpaymentitem?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_paymentitem = curl_init();			
        curl_setopt($curl_paymentitem, CURLOPT_URL, $apiUrl_paymentitem);
        curl_setopt($curl_paymentitem, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_paymentitem, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_paymentitem, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_paymentitem, CURLOPT_RETURNTRANSFER, true);
        $response_paymentitem = curl_exec($curl_paymentitem);			
        $data_paymentitem = json_decode($response_paymentitem, true);

        //receipt
        $apiUrl_receipt="https://eulimsapi.onelab.ph/api/web/v1/receipts/countreceipt?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_receipt = curl_init();			
        curl_setopt($curl_receipt, CURLOPT_URL, $apiUrl_receipt);
        curl_setopt($curl_receipt, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_receipt, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_receipt, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_receipt, CURLOPT_RETURNTRANSFER, true);
        $response_receipt = curl_exec($curl_receipt);			
        $data_receipt = json_decode($response_receipt, true);
        
        //deposit
        $apiUrl_deposit="https://eulimsapi.onelab.ph/api/web/v1/deposits/countdeposit?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_deposit = curl_init();			
        curl_setopt($curl_deposit, CURLOPT_URL, $apiUrl_deposit);
        curl_setopt($curl_deposit, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_deposit, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_deposit, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_deposit, CURLOPT_RETURNTRANSFER, true);
        $response_deposit = curl_exec($curl_deposit);			
        $data_deposit = json_decode($response_deposit, true);
        
        //check
        $apiUrl_check="https://eulimsapi.onelab.ph/api/web/v1/checks/countcheck?rstl_id=".$GLOBALS['rstl_id'];        
        $curl_deposit = curl_init();			
        curl_setopt($curl_check, CURLOPT_URL, $apiUrl_check);
        curl_setopt($curl_check, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_check, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl_check, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
        curl_setopt($curl_check, CURLOPT_RETURNTRANSFER, true);
        $response_check = curl_exec($curl_check);			
        $data_check = json_decode($response_check, true);
        
        $opcount=0; // means data are equal
        $paymentitemcount=0;
        $receiptcount=0;
        $depositcount=0;
        
        if($op < $data){
          
            $opcount=1;
            $oplastid =  Op::find()->max('orderofpayment_id');
            
            $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/ops/resync?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&id=".$oplastid;
            
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            $data = json_decode($response, true);
            //var_dump($data);exit;
            if($data){
                
                $op_count = 0;
                $paymentitem_count = 0;
                $op_sc=0;
                $receipt_count = 0;
                $deposit_count = 0;
                $check_count=0;
                $connection= Yii::$app->financedb;
                $transaction = $connection->beginTransaction();
                $connection->createCommand('set foreign_key_checks=0')->execute();
                

                try {
                 foreach ($data as $op)
                 {    

                        $newOp = new Restore_op();  

                        $newOp->orderofpayment_id= $op['orderofpayment_id'];

                        $newOp->rstl_id= $op['rstl_id'];

                        $newOp->transactionnum= $op['transactionnum'];
                        $newOp->collectiontype_id= $op['collectiontype_id'];
                        $newOp->payment_mode_id= $op['payment_mode_id'];
                        $newOp->on_account= $op['on_account'];
                        $newOp->order_date= $op['order_date'];
                        $newOp->customer_id= $op['customer_id'];
                        $newOp->receipt_id=$op['receipt_id'];
                        $newOp->purpose= $op['purpose'];
                        $newOp->payment_status_id= $op['payment_status_id'];
                        $newOp->save();
                       

                 } 
                    $transaction->commit();
                    
                }catch (\Exception $e) {
                    Yii::$app->session->setFlash('warning', $e->getMessage()); 

                    $transaction->rollBack();
                }catch (\Throwable $e) {
                    Yii::$app->session->setFlash('warning', $e->getMessage()); 
                    $transaction->rollBack();

                }
            } 
            
        }
        
        if($paymentitem < $data_paymentitem){
            $paymentitemcount=1;
            $paymentitemlastid = Paymentitem::find()->max('paymentitem_id');
        

            $apicom=Yii::$app->components['api_config'];
            
           // $apiUrl=$apicom['api_url']."paymentitems/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id;
            $apiUrl=$apicom['api_url']."paymentitems/resync?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&id=".$paymentitemlastid;
           
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            $data = json_decode($response, true);
          
            $paymentitem_count = 0;
            

            $connection= Yii::$app->financedb;
            $transaction = $connection->beginTransaction();
            $connection->createCommand('set foreign_key_checks=0')->execute();
    
            try {
                foreach ($data as $item){
                    $newPaymentitem = new Restore_paymentitem();
                    $id=$item['paymentitem_id'];
                    $count=$this->findPaymentitem($id);
                    
                    if($count > 0){
                        
                    }else{ 
                        $newPaymentitem->paymentitem_id= $item['paymentitem_id'];
                        $newPaymentitem->rstl_id=$item['rstl_id'];
                        $newPaymentitem->request_id=$item['request_id'];
                        $newPaymentitem->request_type_id=$item['request_type_id'];
                        $newPaymentitem->orderofpayment_id=$item['orderofpayment_id'];
                        $newPaymentitem->details=$item['details'];
                        $newPaymentitem->amount=$item['amount'];
                        $newPaymentitem->cancelled=$item['cancelled'];
                        $newPaymentitem->status=$item['status'];
                        $newPaymentitem->receipt_id=$item['receipt_id'];
                        $newPaymentitem->save();
                        $paymentitem_count++;
                    }
                             
                              
                }
               
                $transaction->commit();
                
            }catch (\Exception $e) {
                Yii::$app->session->setFlash('warning', $e->getMessage()); 

                $transaction->rollBack();
            }
        
        }
        
        
        if($receipt < $data_receipt){
            $receiptcount=1;
            $receiptlastid = Receipt::find()->max('receipt_id');
            
               $apicom=Yii::$app->components['api_config'];

               $apiUrl=$apicom['api_url']."receipts/resync?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&id=".$receiptlastid;
           


                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
                curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($curl);

                $data = json_decode($response, true);

                $sql = "SET FOREIGN_KEY_CHECKS = 0;";


                $receipt_count = 0;
                $deposit_count = 0;
                $check_count=0;

                $connection= Yii::$app->financedb;
                $transaction = $connection->beginTransaction();
                $connection->createCommand('set foreign_key_checks=0')->execute();

                try {
                 foreach ($data as $receipt)
                 {     

                        $newReceipt = new Restore_receipt(); 
                        $newReceipt->receipt_id=$receipt['receipt_id'];
                        $newReceipt->rstl_id=$receipt['rstl_id'];
                        $newReceipt->orderofpayment_id=$receipt['orderofpayment_id'];
                        $newReceipt->deposit_type_id=$receipt['deposit_type_id'];
                        $newReceipt->or_series_id=$receipt['or_series_id'];
                        $newReceipt->or_number=$receipt['or_number'];
                        $newReceipt->receiptDate=$receipt['receiptDate'];
                        $newReceipt->payment_mode_id=$receipt['payment_mode_id'];
                        $newReceipt->payor=$receipt['payor'];
                        $newReceipt->collectiontype_id=$receipt['collectiontype_id'];
                        $newReceipt->total=$receipt['total'];
                        $newReceipt->deposit_id=$receipt['local_deposit_id'];
                        $newReceipt->customer_id=$receipt['customer_id'];
                        $newReceipt->terminal_id=1;
                        $newReceipt->cancelled=0;


                        $newReceipt->save();
                        $receipt_count++;

                        foreach ($receipt['check'] as $item){

                            $newCheck = new Restore_check();

                            $newCheck->check_id=$item['local_check_id'];
                           // $newCheck->receipt_id=$item['receipt_id'];
                            $newCheck->receipt_id=$item['receipt_id'];
                            $newCheck->bank=$item['bank'];
                            $newCheck->checknumber=$item['checknumber'];
                            $newCheck->checkdate=$item['checkdate'];
                            $newCheck->amount=$item['amount'];
                            $newCheck->save(false); 

                            $check_count++;    
                        } 


                 } 

                    $transaction->commit();
                    
                }catch (\Exception $e) {
                   
                    Yii::$app->session->setFlash('warning', $e->getMessage()); 

                    $transaction->rollBack();
                }
            
       
        }
        
        if($deposit < $data_deposit){
            $depositcount=1;
            $depositlastid = Deposit::find()->max('deposit_id');
            
                $apicom=Yii::$app->components['api_config'];
                $apiUrl=$apicom['api_url']."deposits/resync?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&id=".$depositlastid;
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
                curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($curl);

                $data = json_decode($response, true);

                $sql = "SET FOREIGN_KEY_CHECKS = 0;";



                $deposit_count = 0;


                $connection= Yii::$app->financedb;
                $transaction = $connection->beginTransaction();
                $connection->createCommand('set foreign_key_checks=0')->execute();

               // echo"<pre>".var_dump($data)."</pre>";exit;
                try {
                    foreach ($data as $item){

                        $newDeposit = new Restore_deposit();
                        $count=$this->findDeposit($item['local_deposit_id']);

                        $newDeposit->deposit_id= $item['local_deposit_id'];
                        $newDeposit->rstl_id= $item['rstl_id'];
                        $newDeposit->or_series_id= $item['or_series_id'];
                        $newDeposit->start_or= $item['start_or'];
                        $newDeposit->end_or= $item['end_or'];
                        $newDeposit->amount= $item['amount'];
                        $newDeposit->deposit_type_id= $item['deposit_type_id'];
                        $newDeposit->deposit_date= $item['deposit_date'];

                        if($count == 1){

                        }else{ 
                            $newDeposit->save(); 
                            $deposit_count++;
                        }


                    }

                    $transaction->commit();
                   
                }catch (\Exception $e) {
                    Yii::$app->session->setFlash('warning', $e->getMessage()); 

                    $transaction->rollBack();
                }
            
        }
     
         //Yii::$app->session->setFlash('success', 'Hype!!!');
         return $this->redirect('/api/finance');
     }
     
     public function actionRes_receipt($year){
            //$month = (int)$_POST['month'] + 1;
            //$year =  $_POST['year'];

            for($month=1;$month < 13;$month++){
           // for($month=12;$month > 0;$month--){  
                if($year == "0000"){
                    $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/receipts/restore?rstl_id=11&opds=0000-00-00&opde=00-00-00";
                  }
                else{
                    $month_value=str_pad($month,2,"0",STR_PAD_LEFT);
                    $start = $year."-".$month_value;
                    $end = $year."-".$month_value;

                    $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

                    $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/receipts/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&opds=".$start."&opde=".$end;


                }
            

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
                curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($curl);

                $data = json_decode($response, true);
                //var_dump($data);exit;
                if($data){
                     $sql = "SET FOREIGN_KEY_CHECKS = 0;";

                    $receipt_count = 0;
                    $check_count=0;
                    $connection= Yii::$app->financedb;
                    $transaction = $connection->beginTransaction();
                    $connection->createCommand('set foreign_key_checks=0')->execute();


                    try {
                     foreach ($data as $receipt)
                     {    

                                            $newReceipt = new Restore_receipt(); 

                        //$newReceipt->receipt_id=$receipt['receipt_id'];
                        $newReceipt->receipt_id=$receipt['receipt_id'];
                        $newReceipt->rstl_id=$receipt['rstl_id'];
                        $newReceipt->orderofpayment_id=$receipt['orderofpayment_id'];
                        $newReceipt->deposit_type_id=$receipt['deposit_type_id'];
                        $newReceipt->or_series_id=$receipt['or_series_id'];
                        $newReceipt->or_number=$receipt['or_number'];
                        $newReceipt->receiptDate=$receipt['receiptDate'];
                        $newReceipt->payment_mode_id=$receipt['payment_mode_id'];
                        $newReceipt->payor=$receipt['payor'];
                        $newReceipt->collectiontype_id=$receipt['collectiontype_id'];
                        $newReceipt->total=$receipt['total'];
                        $newReceipt->deposit_id=$receipt['local_deposit_id'];
                        $newReceipt->customer_id=$receipt['customer_id'];
                        $newReceipt->terminal_id=1;
                        $newReceipt->cancelled=0;


                        $newReceipt->save(false);
                        $receipt_count++;

                        foreach ($receipt['check'] as $item){

                            $newCheck = new Restore_check();

                            $newCheck->check_id=$item['local_check_id'];
                            $newCheck->receipt_id=$item['receipt_id'];
                            $newCheck->bank=$item['bank'];
                            $newCheck->checknumber=$item['checknumber'];
                            $newCheck->checkdate=$item['checkdate'];
                            $newCheck->amount=$item['amount'];
                            $newCheck->rstl_id=$item['rstl_id'];
                            $newCheck->save(false); 

                            $check_count++;    
                        }


                     } 
                                            $dt=$month."-".$year;

                                            $model= BackuprestoreLogs::find()->where(['data_date'=>$dt])->one();

                                            if($model){
                                                    $model->receipt=$receipt_count;
                                                    $model->check=$check_count;  
                                                    $model->save(false);
                                            }else{
                                                    $model= new BackuprestoreLogs();
                                                    $model->activity = "Restored data for the month of ".$month."-".$year;
                                                    $model->transaction_date = date('Y-M-d');
                                                    $model->data_date=$month."-".$year;
                                                    $model->receipt=$receipt_count;
                                                    $model->check=$check_count;  

                                                    $model->save(false);
                                            }

                        $transaction->commit();

                        $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                        Yii::$app->session->setFlash('success', ' Records Successfully Restored for the year '.$year); 

                    }catch (\Exception $e) {
                        Yii::$app->session->setFlash('warning', $e->getMessage()); 

                        $transaction->rollBack();
                    }catch (\Throwable $e) {
                        Yii::$app->session->setFlash('warning', $e->getMessage()); 
                        $transaction->rollBack();

                    }
                }        

            }
    }
     
}