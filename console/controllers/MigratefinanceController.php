<?php
namespace console\controllers;

use Yii;
use \yii\console\Controller;
use \common\models\finance\OrderofpaymentMigration;
use \common\models\finance\Orderofpayment;
use \common\models\lab\Customer;
use \common\models\finance\ReceiptMigration;
use \common\models\finance\Receipt;
use \common\models\finance\Deposit;
use \common\models\finance\DepositMigration;
use \common\models\finance\PaymentitemMigration;
use \common\models\finance\Paymentitem;
use \common\models\finance\Check;
use \common\models\finance\CheckMigration;
use \common\models\finance\CollectionMigration;
use \common\models\finance\Collection;

/**
 * 
 */
class MigratefinanceController extends Controller
{
	public $message="Hello Finance";

	public function actionIndex($rstl="100"){
		$limit = 2; 

        //THERE ARE ALL 19 PROCEDURES TO FOLLOW ON THE SP

		//qeury the order of payment migration table
		$ops = OrderofpaymentMigration::find()->where(['is_migrated'=>0])->limit($limit)->all();

		//saving the op to the live table
		foreach ($ops as $op) {
			$Connection= Yii::$app->financedb;
            $Transaction =$Connection->beginTransaction();
            echo " \n Setting foreign_key_checks to 0";
            $Connection->createCommand('set foreign_key_checks=0')->execute();

            echo "\n Executing orderofparmentmigration id: ".$op->local_orderofpayment_id;
            try {

                $live_op = new OrderofpaymentMigration;
                $live_op->attributes = $op->attributes;
                $live_op->local_customer_id = $live_op->customer_id; //saving copy of the local customer id

                //search for customer 
                 echo " \n \n Searching exsiting  customer using code from OP: ".$op->rstl_id."-".$op->local_customer_id;
                 $checkcustomer = Customer::find()->where(['customer_code'=>$op->rstl_id."-".$op->local_customer_id])->one();
                 if($checkcustomer){
                        echo "customer found";
                        $live_op->customer_id = $checkcustomer->customer_id;
                 }

                 //trying to save the OP so we can do all other procedure
                 if($live_op->save(false)){
                    echo "\n OP Save!";
                    //find the receipts
                    echo "\n Searching the receiptmigration using local_orderofpayment_id ".$op->local_orderofpayment_id;
                    $receipts = ReceiptMigration::find()->where(['local_orderofpayment_id'=>$op->local_orderofpayment_id,'rstl_id'=>$op->rstl_id])->all();


                    foreach ($receipts as $receipt) {
                        echo "\n Executing receiptmigration id : ".$receipt->receipt_id;
                        $live_receipt = new Receipt;
                        $live_receipt->attributes = $receipt->attributes;
                        if($live_receipt->collectiontype_id==11){
                            $live_receipt->collectiontype_id=1;
                        }
                        // $live_receipt->local_deposit_type_id = $live_receipt->deposit_type_id;
                        if($live_receipt->deposit_type_id==0){
                            $live_receipt->deposit_type_id=1;
                        }elseif($live_receipt->deposit_type_id==1){
                            $live_receipt->deposit_type_id=2;
                        }
                        $live_receipt->orderofpayment_id=$op->orderofpayment_id; //8

                        //*************************************************************                        

                        //searching  existing in deposit tbl where the receipt->ornumber belongs shuid be between start and end or
                        echo "\n Searching for the ornumber of ".$receipt->or_number." on the deposit.";
                        $checkdeposit = Deposit::find()->where(['rstl_id'=>$op->rstl_id])
                               ->andWhere(['>', 'end_or', $receipt->or_number])
                               ->andWhere(['<', 'start_or', $receipt->or_number])
                               ->one();
                        //validate this and add rstl_id as condition
                        if($checkdeposit){
                            echo "\n Deposit Found";
                            //assigning the deposit id to a receipt
                            $live_receipt->deposit_id = $checkdeposit->deposit_id;
                            $live_receipt->local_deposit_id = $checkdeposit->deposit_id;
                        }else{
                            echo "\n Deposit not found!, searching on depositmigration table ";

                            $checkdeposit2 = DepositMigration::find()->where(['rstl_id'=>$op->rstl_id])
                               ->andWhere(['>', 'end_or', $receipt->or_number])
                               ->andWhere(['<', 'start_or', $receipt->or_number])
                               ->one();
                            if($checkdeposit2){

                                echo "\n Deposit Found ".$checkdeposit2->deposit_id.", Creating new DEposit record got from deposit migration";

                                $live_deposit = new Deposit;
                                $live_deposit->attributes = $checkdeposit2->attributes;
                                $live_deposit->deposit_type_id=$checkdeposit2->deposit_type_id+1;
                                if($live_deposit->save(false)){
                                    //assign the new deposit to the receipt
                                    $live_receipt->deposit_id = $checkdeposit2->deposit_id;
                                    $live_receipt->local_deposit_id = $checkdeposit2->deposit_id;
                                }
                            }
                        }
                        $live_op->payment_mode_id=$live_receipt->payment_mode_id;
                        echo "\n saving receipt";

                        if($live_receipt->save(false)){

                            //***********************************************************
                            //Procedure 14 and 15
                            //find the checks
                            echo "\n Searching for checkmigration using reciept_id : ".$live_receipt->local_receipt_id;

                            $checks = CheckMigration::find()->where(['receipt_id'=>$live_receipt->local_receipt_id,'rstl_id'=>$op->rstl_id])->all();
                            foreach ($checks as $check) {
                                echo "\n Executing checkmigration local id : ".$check->local_check_id;
                                $live_check = new Check;
                                $live_check->attributes = $check->attributes;
                                $live_check->receipt_id = $live_receipt->receipt_id;
                                if($live_check->save(false)){
                                    echo "\n checkmigration save id :".$live_check->check_id;
                                }

                            }
                            //14 and 15 finish
                            //*************************************************************



                            //connectinmg the receipt and op vice versa
                            $live_op->receipt_id = $live_receipt->receipt_id;

                            //if the op has receipt_id then ipdate the payment status id into 2 means paid
                            if(isset($live_op->receipt_id)){
                                $live_op->payment_status_id=2;
                            }

                            $live_op->save(false);
                            echo "\n saving OP again!";
                            //***********************************************************
                            //10. create payment items using the collections
                            //search on collectio using the receipt
                            echo "\n Searching Collections using receipt local id : ".$live_receipt->local_receipt_id;
                            $collections = CollectionMigration::find()->where(['oldColumn_receipt_id'=>$live_receipt->local_receipt_id,'rstl_id'=>$live_op->rstl_id])->all();
                            foreach ($collections as $collection) {
                                if(!isset($collections->orderofpayment_id)){
                                    //create a payment item
                                    echo "\n Creating paymentItem using collection old id: ".$collection->collection_old_id;
                                    $live_paymentitem = new Paymentitem;
                                    $live_paymentitem->rstl_id=$live_op->rstl_id;
                                    $live_paymentitem->request_id=0;
                                    $live_paymentitem->request_type_id=0;
                                    $live_paymentitem->orderofpayment_id=0;
                                    $live_paymentitem->details=$collection->nature;
                                    $live_paymentitem->amount=$collection->amount;
                                    $live_paymentitem->cancelled=0;
                                    $live_paymentitem->status=2;
                                    $live_paymentitem->receipt_id=$live_receipt->receipt_id;
                                    $live_paymentitem->local_receipt_id=$collection->oldColumn_receipt_id;
                                    if($live_paymentitem->save(false)){
                                        echo "\n Payment item Save";
                                    }
                                }
                            }
                            //************************************************************
                            // 9. connect payment to op & 11. then assign the sum og recipt for all payment using the same receipt id
                            echo "\n Searching PaymentitemMigration using local receipt id: ".$receipt->local_receipt_id;
                            $payments =  PaymentitemMigration::find()->where(['receipt_id'=>$receipt->local_receipt_id,'rstl_id'=>$op->rstl_id])->all();
                           
                            foreach ($payments as $payment) {
                               echo "\n Executing paymentitemmigration local id: ".$payment->local_paymentitem_id;
                                $live_payment = new Paymentitem;
                                $live_payment->attributes = $payment->attributes;
                                $live_payment->receipt_id=$live_op->receipt_id;
                                $live_payment->orderofpayment_id=$live_op->orderofpayment_id;
                                $live_payment->status=2;
                                if($live_payment->save(false)){
                                    echo "\n paymentitem save";
                                }
                            }
                            echo "\n Searching payment items to calculate the SUM TOTAL";
                            $totalpm = Paymentitem::find()->where(['receipt_id'=>$live_receipt->receipt_id,'rstl_id'=>$live_op->rstl_id])->all();
                             $total = 0;
                            foreach ($totalpm as $pms ) {
                                 $total+=$pms->amount;
                            }
                            $live_receipt->total = $total; //11 finish
                            $live_receipt->save(false);
                            echo "\n updating the reciept with new found total";
                            //***********************************************************



                        }
                    }
                 }

                

               


                $op->is_migrated=1;
                if($op->save()){
                    $Transaction->commit();
                }else{
                     $Transaction->rollback();
                }
                echo " \n Setting foreign_key_checks to 1";
                $Connection->createCommand('set foreign_key_checks=1')->execute();
                echo " \n \n Execution done on OPmigration id : ".$op->local_orderofpayment_id;
                echo " \n \n**************************   ";
            	
            } catch (Exception $e) {
            	$Transaction->rollback();
               	echo "Transaction rollback in orderofpayment id : ".$op->orderofpayment_id;
            	echo " \n Setting foreign_key_checks to 1";
          	    $Connection->createCommand('set foreign_key_checks=1')->execute();
            }
		}

        echo " \n \n Job Done";
	}	
}
?>