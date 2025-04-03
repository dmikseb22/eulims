<?php

namespace console\controllers;
// namespace app\commands;

use Yii;
use \yii\console\Controller;
use common\models\services\Archive;
use common\models\finance\Op;
use common\models\lab\Request;
use common\components\Notification;
/**
 * This is an example...


**/

class ArchiveController extends Controller
{

 	public $message;

    
    public function options($actionID)
    {
        return ['message'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message'];
    }


 
    public function actionIndex()
    {
        
        set_time_limit(0);
        $year = date('Y')-5; 
        $requests = Request::find()->leftJoin('tbl_customer','tbl_request.customer_id = tbl_customer.customer_id')->where('year(tbl_request.request_datetime) = '.$year.'')->andWhere(['tbl_request.is_migrated' => 0])->limit(10)->all(); 
        
        foreach ($requests as $request)
        {
            $req_no = $request['request_ref_num'];
            $req_date = $request['request_datetime'];
            $req_status = $request['status_id'];
            $check = Archive::find()->where(['request_no' => $req_no])->limit(50)->all();
            
            if(count($check) < 1){
                $content = []; $samples = []; 
                ($request->customer['customer_name'] == null ) ? $customer = 'Not Available' : $customer = $request->customer['customer_name']; 
                ($request->request_ref_num == null ) ? $ref = 'Not Available' : $ref = $request->request_ref_num;

                foreach ($request->samples as $list) {
                    
                    $analysis = [];
                    foreach($list->analyses as $a){
                        $analysis[] = [
                            'date' => $a['date_analysis'],
                            'name' => $a['testname'],
                            'method' => $a['method'],
                            'references' => $a['references'],
                            'fee' => $a['fee']
                        ];
                    }

                    $samples[] = [  
                        'code' => $list['sample_code'],
                        'name' => $list['samplename'],
                        'description' => $list['description'],
                        'analysis' => $analysis
                    ];
                }

                $op = Op::find()->where(['orderofpayment_id' => $request->payment['orderofpayment_id']])->one();

                $content[] = [
                    'request' => [
                        'id' => $request->request_id,
                        'rstl_id' => $request->rstl_id,
                        'purpose' => $request->purpose['name'],
                        'reference_num' => $request->request_ref_num,
                        'request_datetime' => $request->request_datetime,
                        'labtype' => $request->lab['labname'],
                        'discount' => $request->discount,
                        'total' => $request->total,
                        'conforme' => $request->conforme,
                        'received_by' => $request->receivedBy,
                        'status' => $request->status['status']
                    ],
                    'customer' => [
                        'name' => $request->customer['customer_name'],
                        'address' => $request->customer['address']
                    ],
                    'samples' => $samples,
                    'payment' => [
                        'amount' => $request->payment['amount'],
                        'transaction' => $op['transactionnum'],
                        'invoice' => $op['invoice_number']
                    ]
                ];

                $id = $request->request_id;
                $status = Request::find()->where(['request_id' => $id])->one();
                $status->is_migrated = 1;
                $status->save(false);

                $new = new Archive;
                $new->customer = $customer;
                $new->request_no = $ref;
                $new->content = json_encode($content);
                $new->status = ($req_status == 0) ? 'Cancelled' : 'Confirmed';
                $new->type = 'New';
                $new->requested_at = $req_date;
                $new->save();
            
            }else{
                $id = $request->request_id;
                $status = Request::find()->where(['request_id' => $id])->one();
                $status->is_migrated = 1;
                $status->save(false);
            }

        }

        $notif= new Notification();
        $mes= "Archive Migration Completed.";
        $res=$notif->sendSMS("", "", '09557650803', 'Archive Cronjob', $mes, "eULIMS", 'Archive Migration', 'Index');
        echo $res;
    }
   

}