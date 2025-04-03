<?php


namespace frontend\modules\finance\controllers;


use linslin\yii2\curl;
use common\models\api\YiiMigration;
use common\models\lab\Restore_request;
use common\models\lab\Restore_analysis;
use common\models\lab\Restore_sample;
use common\models\lab\Restore_customer;



use Yii;
use common\models\api\YiiMigrationSearch;
/**
 * Description of UpdbController
 *
 * @author ts-ict5
 */
class RestorelabController extends \yii\web\Controller{
    //customer
    //request
    //sample
    //analysis
    
    public function actionIndex()
    {

        $model = new YiiMigration();
        
        $searchModel = new YiiMigrationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      //  $dataProvider->pagination->pageSize=10;
        $customer = Restore_customer::find()->count();
        $request = Restore_request::find()->count();
        $sample = Receipt::find()->count();
        $analysis= Deposit::find()->count();

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
        
        
        $opdata=number_format($op)."/ ".number_format($data);
        $paymentitemdata=number_format($paymentitem)."/ ".number_format($data_paymentitem);
        $receiptdata=number_format($receipt)."/ ".number_format($data_receipt);
        $depositdata=number_format($deposit)."/ ".number_format($data_deposit);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'op'=>$opdata,
            'paymentitem'=> $paymentitemdata, 
            'receipt'=> $receiptdata, 
            'deposit'=> $depositdata
        ]);

    }
    
     public function actionSync($tblname)
    { 
       // $model=$this->findModel($id);
       /* 
        return $this->renderAjax('view', [
           'tblname' => $tblname
        ]);*/
        if($tblname == "tbl_orderofpayment"){
            $this->actionPostop();
        }
        elseif ($tblname == "tbl_receipt") {
            $this->actionPostreceipt();
        }
        elseif ($tblname == "tbl_deposit") {
            $this->actionPostdeposit();
        }
        elseif ($tblname == "tbl_paymentitem") {
            $this->actionPostpaymentitem();
        }else{
            
        }
        
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->session->setFlash('success', 'Successfully updated!');
             return $this->redirect(['/finance/updb']);
        } else {
            if(Yii::$app->request->isAjax){
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    ////////////----------------------------------------------------------------//////////////////////////////////////
    public function actionPostop(){
        //$url = "http://ulimsportal.onelab.ph/api/api/sync_orderofpayment";
         //$url = "http://www.eulims.local/api/api/sync_orderofpayment";
        $url="https://eulimsapi.onelab.ph/api/web/v1/apis/sync_orderofpayment"; 
        $table = "tbl_orderofpayment";
        $model= YiiMigration::find()->where(['tblname'=>$table])->one();
        $id=$model->num;
        $limit=$id+2;
        $data = Yii::$app->financedb->createCommand("SELECT * FROM `tbl_orderofpayment` WHERE is_sync_up=0")->queryAll();
        $Op_details=[];
        if($data){
            foreach($data as $op){
                $opid=$op['orderofpayment_id'];
                $paymentitem = Yii::$app->financedb->createCommand("SELECT * FROM `tbl_paymentitem` WHERE is_sync_up=0 AND `orderofpayment_id` = ".$opid)->queryAll();
                $Paymentitem_details=[];
                foreach($paymentitem as $item){
                    $detail_paymentitem=[
                        'paymentitem_id'=> $item['paymentitem_id'],
                        'rstl_id'=>$item['rstl_id'],
                        'request_id'=>$item['request_id'],
                        'request_type_id'=>$item['request_type_id'],
                        'orderofpayment_id'=>$opid,
                        'details'=>$item['details'],
                        'amount'=>$item['amount'],
                        'cancelled'=>$item['cancelled'],
                        'status'=>$item['status'],
                        'receipt_id'=>$item['receipt_id']
                    ];
                    array_push($Paymentitem_details, $detail_paymentitem);
                }
                $detail=[
                        'orderofpayment_id'=>$op['orderofpayment_id'],
                        'rstl_id'=> $op['rstl_id'],
                        'transactionnum'=>$op['transactionnum'],
                        'collectiontype_id'=>$op['collectiontype_id'],
                        'order_date'=>$op['order_date'],
                        'customer_id'=>$op['customer_id'],
                        'purpose'=>$op['purpose'],
                        'total_amount'=>$op['total_amount'],
                        'local_orderofpayment_id'=>$op['orderofpayment_id'],
                        'payment_mode_id'=> $op['payment_mode_id'],
                        'on_account'=> $op['on_account'],
                        'receipt_id'=>$op['receipt_id'],
                        'purpose'=> $op['purpose'],
                        'payment_status_id'=> $op['payment_status_id'],
                        'is_sync_up' => $op['is_sync_up'],
                        'is_updated' => $op['is_updated'],
                        'is_deleted' => $op['is_deleted'],
                        'payment_item' => $Paymentitem_details

                ];
                array_push($Op_details, $detail);
            }

            $curl = new curl\Curl();

            $content = json_encode(['data'=>$Op_details]);
           // echo "<pre>";var_dump(json_decode($content));echo "</pre>";exit;
            $response = $curl->setRequestBody($content)
                ->setHeaders([
                  'Content-Type' => 'application/json',
                  'Content-Length' => strlen($content),
                ])->post($url);
           // echo "<pre>";var_dump(json_decode($response));echo "</pre>";exit;
            if($response){
               $data = json_decode($response);
               foreach ($data as $res) {
                   //$ids= implode(',',$res->idsave);
                   $idsave = $res->idsave;
                   $idfirst=$res->idfirst;
               }

               $updatemodel = Yii::$app->financedb->createCommand("UPDATE tbl_orderofpayment set is_sync_up=1 WHERE orderofpayment_id >= ".$idfirst." AND orderofpayment_id <= ".$idsave)->execute();
               $updatemodelpayment = Yii::$app->financedb->createCommand("UPDATE tbl_paymentitem set is_sync_up=1 WHERE orderofpayment_id >= ".$idfirst." AND orderofpayment_id <= ".$idsave)->execute();     
               if($model){
                    $model->num=$idsave;
                    $model->save(false);
               }
            }
        }
        Yii::$app->session->setFlash('success', 'Successfully posted!');
        return $this->redirect(['/finance/updb']);
        
    }
    
   public function actionPostreceipt(){
        //$url = "http://ulimsportal.onelab.ph/api/api/sync_receipt";
        //$url = "http://www.eulims.local/api/api/sync_receipt";
       $url="https://eulimsapi.onelab.ph/api/web/v1/apis/sync_receipt";
        $table = "tbl_receipt";
        $model= YiiMigration::find()->where(['tblname'=>$table])->one();
        $id=$model->num;
        $limit=$id+100;
        $data = Yii::$app->financedb->createCommand("SELECT * FROM `tbl_receipt` WHERE is_sync_up=0 AND receipt_id > ".$id." AND receipt_id < ".$limit)->queryAll();
        $Receipt_details=[];
        // echo "<pre>";echo $id.$limit;echo "</pre>";exit;
        if($data){
           foreach($data as $receipt){
                $receiptid=$receipt['receipt_id'];
                $check = Yii::$app->financedb->createCommand("SELECT * FROM `tbl_check` WHERE is_sync_up=0 AND `receipt_id` = ".$receiptid)->queryAll();
                $check_details=[];
                foreach($check as $item){
                    $detail_check=[

                        'local_check_id'=>$item['check_id'],
                        'receipt_id'=>$receiptid,
                        'bank'=>$item['bank'],
                        'checknumber'=>$item['checknumber'],
                        'checkdate'=>$item['checkdate'],
                        'amount'=>$item['amount']
                    ];
                    array_push($check_details, $detail_check);
                }
                //-----------------------------
                $ops = Yii::$app->financedb->createCommand("SELECT * FROM `tbl_orderofpayment` WHERE is_sync_up=0 AND `receipt_id` = ".$receiptid)->queryAll();
                $op_details=[];
                foreach($ops as $op){
                    $opid=$op['orderofpayment_id'];
                    $paymentitem = Yii::$app->financedb->createCommand("SELECT * FROM `tbl_paymentitem` WHERE is_sync_up=0 AND `orderofpayment_id` = ".$opid)->queryAll();
                    $Paymentitem_details=[];
                    foreach($paymentitem as $item){
                        $detail_paymentitem=[
                            'paymentitem_id'=> $item['paymentitem_id'],
                            'rstl_id'=>$item['rstl_id'],
                            'request_id'=>$item['request_id'],
                            'request_type_id'=>$item['request_type_id'],
                            'orderofpayment_id'=>$opid,
                            'details'=>$item['details'],
                            'amount'=>$item['amount'],
                            'cancelled'=>$item['cancelled'],
                            'status'=>$item['status'],
                            'receipt_id'=>$receiptid,
                        ];
                        array_push($Paymentitem_details, $detail_paymentitem);
                    }
                    $detail_op=[
                        'orderofpayment_id'=>$op['orderofpayment_id'],
                        'rstl_id'=> $op['rstl_id'],
                        'transactionnum'=>$op['transactionnum'],
                        'collectiontype_id'=>$op['collectiontype_id'],
                        'order_date'=>$op['order_date'],
                        'customer_id'=>$op['customer_id'],
                        'purpose'=>$op['purpose'],
                        'total_amount'=>$op['total_amount'],
                        'local_orderofpayment_id'=>$op['orderofpayment_id'],
                        'payment_mode_id'=> $op['payment_mode_id'],
                        'on_account'=> $op['on_account'],
                        'receipt_id'=>$receiptid,
                        'purpose'=> $op['purpose'],
                        'payment_status_id'=> $op['payment_status_id'],
                        'is_sync_up' => $op['is_sync_up'],
                        'is_updated' => $op['is_updated'],
                        'is_deleted' => $op['is_deleted'],
                        'payment_item' => $Paymentitem_details
                    ];
                    array_push($op_details, $detail_op);
                }
                
                $detail=[
                        'local_receipt_id'=>$receipt['receipt_id'],
                        'rstl_id'=>$receipt['rstl_id'],
                        'local_orderofpayment_id'=>$receipt['orderofpayment_id'],
                        'deposit_type_id'=>$receipt['deposit_type_id'],
                        'or_series_id'=>$receipt['or_series_id'],
                        'or_number'=>$receipt['or_number'],
                        'receiptDate'=>$receipt['receiptDate'],
                        'payment_mode_id'=>$receipt['payment_mode_id'],
                        'payor'=>$receipt['payor'],
                        'collectiontype_id'=>$receipt['collectiontype_id'],
                        'total'=>$receipt['total'],
                        'local_deposit_id'=>$receipt['deposit_id'],
                        'customer_id'=>$receipt['customer_id'],
                        'terminal_id'=>1,
                        'cancelled'=>0,
                        'check' => $check_details,
                        'op'=> $op_details

                ];
                array_push($Receipt_details, $detail);
            }

            $curl = new curl\Curl();

            $content = json_encode(['data'=>$Receipt_details]);
          // echo "<pre>";var_dump(json_decode($content));echo "</pre>";exit;
            $response = $curl->setRequestBody($content)
                ->setHeaders([
                  'Content-Type' => 'application/json',
                  'Content-Length' => strlen($content),
                ])->post($url);
         //echo "<pre>";var_dump(json_decode($response));echo "</pre>";exit;
            if($response){
               $data = json_decode($response);
               foreach ($data as $res) {
                   //$ids= implode(',',$res->idsave);
                   $idsave = $res->idsave ? $res->idsave : "";
                   $idsaveop= $res->idsaveop;
                   $idsavepaymentitem=$res->idsavepaymentitem;
                  // $idfail=$res->idfail;
               }

               $updatemodel = Yii::$app->financedb->createCommand("UPDATE tbl_receipt set is_sync_up=1 WHERE receipt_id > ".$id." AND receipt_id <= ".$idsave)->execute();
               $updatemodelop = Yii::$app->financedb->createCommand("UPDATE tbl_orderofpayment set is_sync_up=1 WHERE receipt_id > ".$id." AND receipt_id <= ".$idsave)->execute();
               $updatemodelpayment = Yii::$app->financedb->createCommand("UPDATE tbl_paymentitem set is_sync_up=1 WHERE receipt_id > ".$id." AND receipt_id <= ".$idsave)->execute();
               if($model){
                    $model->num=$idsave;
                    $model->save(false);
               }
            } 
        }
        Yii::$app->session->setFlash('success', 'Successfully posted!');
        return $this->redirect(['/finance/updb']);
    }
    
     public function actionPostdeposit(){
       //$url = "http://ulimsportal.onelab.ph/api/api/sync_deposit";
        $url = "https://eulimsapi.onelab.ph/api/web/v1/apis/sync_deposit";
        $table = "tbl_deposit";
        $model= YiiMigration::find()->where(['tblname'=>$table])->one();
        $id=$model->num;
        $limit=$id+100;
        $data = Yii::$app->financedb->createCommand("SELECT * FROM `tbl_deposit` WHERE is_sync_up=0 AND deposit_id > ".$id." AND deposit_id <= ".$limit)->queryAll();
        $Deposit_details=[];
        if($data){
             foreach($data as $item){
                $detail=[
                       //---------------
                        'local_deposit_id'=> $item['deposit_id'],
                        'rstl_id'=> $item['rstl_id'],
                        'or_series_id'=> $item['or_series_id'],
                        'start_or'=> $item['start_or'],
                        'end_or'=> $item['end_or'],
                        'amount'=> $item['amount'],
                        'deposit_type_id'=> $item['deposit_type_id'],
                        'deposit_date'=> $item['deposit_date']

                ];
                array_push($Deposit_details, $detail);
            }

            $curl = new curl\Curl();

            $content = json_encode(['data'=>$Deposit_details]);
           // echo "<pre>";var_dump(json_decode($content));echo "</pre>";exit;
            $response = $curl->setRequestBody($content)
                ->setHeaders([
                  'Content-Type' => 'application/json',
                  'Content-Length' => strlen($content),
                ])->post($url);
           // echo "<pre>";var_dump(json_decode($response));echo "</pre>";exit;
            if($response){
               $data = json_decode($response);
               foreach ($data as $res) {
                   //$ids= implode(',',$res->idsave);
                   $idsave = $res->idsave ? $res->idsave : "";
                  // $idfail=$res->idfail;
               }

               $updatemodel = Yii::$app->financedb->createCommand("UPDATE tbl_deposit set is_sync_up=1 WHERE deposit_id > ".$id." AND deposit_id <= ".$idsave)->execute();

               if($model){
                    $model->num=$idsave;
                    $model->save(false);
               }
            }
        }
       
        Yii::$app->session->setFlash('success', 'Successfully posted!');
        return $this->redirect(['/finance/updb']);
    }

     public function actionPostpaymentitem(){
        //$url = "http://ulimsportal.onelab.ph/api/api/sync_paymentitem";
       // $url = "http://www.eulims.local/api/api/sync_paymentitem";
        $url="https://eulimsapi.onelab.ph/api/web/v1/apis/sync_paymentitem";
        $table = "tbl_paymentitem";
        $model= YiiMigration::find()->where(['tblname'=>$table])->one();
        /*$id=$model->num;
        $limit=$id+2; */
        $data = Yii::$app->financedb->createCommand("SELECT * FROM `tbl_paymentitem` WHERE orderofpayment_id=0 and is_sync_up=0")->queryAll();
        
        $Paymentitem_details=[];
        if($data){
             foreach($data as $item){
                $detail=[
                    'paymentitem_id'=> $item['paymentitem_id'],
                    'rstl_id'=>$item['rstl_id'],
                    'request_id'=>$item['request_id'],
                    'request_type_id'=>$item['request_type_id'],
                    'orderofpayment_id'=>0,
                    'details'=>$item['details'],
                    'amount'=>$item['amount'],
                    'cancelled'=>$item['cancelled'],
                    'status'=>$item['status'],
                    'receipt_id'=>$item['receipt_id']

                ];
                array_push($Paymentitem_details, $detail);
            }

            $curl = new curl\Curl();

            $content = json_encode(['data'=>$Paymentitem_details]);
           // echo "<pre>";var_dump(json_decode($content));echo "</pre>";exit;
            $response = $curl->setRequestBody($content)
                ->setHeaders([
                  'Content-Type' => 'application/json',
                  'Content-Length' => strlen($content),
                ])->post($url);
            //echo "<pre>";var_dump(json_decode($response));echo "</pre>";exit;
            if($response){
               $data = json_decode($response);
               foreach ($data as $res) {
                   //$ids= implode(',',$res->idsave);
                   $idsave = $res->idsave ? $res->idsave : "";
                  // $idfail=$res->idfail;
               }

               $updatemodel = Yii::$app->financedb->createCommand("UPDATE tbl_paymentitem set is_sync_up=1 WHERE orderofpayment_id=0")->execute();

               if($model){
                    $model->num=$idsave;
                    $model->save(false);
               }
            }
        }
       
       Yii::$app->session->setFlash('success', 'Successfully posted!');
        return $this->redirect(['/finance/updb']); 
    }
    
    protected function findModel($id)
    {
        if (($model = YiiMigration::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
