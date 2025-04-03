<?php

namespace console\controllers;
// namespace app\commands;

use Yii;
use \yii\console\Controller;
// use \common\models\lab\Jobportal;
// use \common\components\Functions;
use \common\models\lab\RequestMigration;
use \common\models\lab\AnalysisMigration;
use \common\models\lab\SampleMigration;
use \common\models\lab\CustomerMigration;
use \common\models\lab\Request;
use \common\models\lab\Analysis;
use \common\models\lab\Sample;
use \common\models\lab\Customer;

/**
 * This is an example...
**/

class MigrateportalController extends Controller
{

 	public $message;

    public function actionIndex($rstl="100",$region="100")
    {
        $limit = 2;

        //query the request migration table
        $requests = RequestMigration::find()->where(['is_migrated'=>0])->limit($limit)->all();

        //saving the request to live tbl
        foreach ($requests as $request ) {

            $Connection= Yii::$app->labdb;
            $Transaction =$Connection->beginTransaction();
            echo " \n Setting foreign_key_checks to 0";
            $Connection->createCommand('set foreign_key_checks=0')->execute();

            echo " \n Executing requestmigration id : ".$request->request_id;
            try {

                //request live
                $live_request = new Request;
                $live_request->attributes = $request->attributes;
                $live_request->discount_id = $live_request->discount;

                //searching existing customer
                echo " \n \n Searching existing customer using code: ".$request->rstl_id.'-'.$request->customer_old_id;
                $checkcustomer = Customer::find()->where(['customer_code'=> $request->rstl_id.'-'.$request->customer_old_id])->one();
                if($checkcustomer){
                    echo " :  customer found";
                    //asigning the customer
                    $live_request->customer_id=$checkcustomer->customer_id;
                }else{
                     echo " :  customer not found, searching on migration table ";
                    echo " \n \n Searching customermigration using request_old_id: ".$request->request_old_id;
                    $customer = CustomerMigration::find()->where(['customer_old_id'=>$request->customer_old_id,'rstl_id'=>$request->rstl_id])->one();

                    if($customer){
                        $newcustomer = new Customer;
                        $newcustomer->attributes = $customer->attributes;
                        $newcustomer->save(false);
                        $live_request->customer_id=$newcustomer->customer_id;
                    }
                }
               
                if($live_request->save(false)){

                    
                    
                    

                    //find the samples
                    echo " \n \n Searching samplemigration using request_old_id: ".$request->request_old_id;
                    $samples = SampleMigration::find()->where(['old_request_id'=>$request->request_old_id,'rstl_id'=>$request->rstl_id])->all();

                    foreach ($samples as $sample) {
                        echo " \n Executing samplemigration id : ".$sample->sample_id;
                        $live_sample = new Sample;
                        $live_sample->attributes=$sample->attributes;
                        $live_sample->request_id=$live_request->request_id;

                        //as per the sp instruction
                        switch($live_sample->active){
                            case '0':
                            $live_sample->active=1;
                            break;
                            case '1':
                            $live_sample->active=0;
                            break;
                            default:
                            $live_sample->active=0;
                            break;
                        }

                        if($live_sample->save(false)){

                            //find the analysis
                             echo " \n \n Searching analysismigration using sample_old_id: ".$sample->sample_old_id;
                            $analyses = AnalysisMigration::find()->where(['old_sample_id'=>$sample->sample_old_id,'rstl_id'=>$request->rstl_id])->all();

                            foreach ($analyses as $analysis) {
                                 echo " \n Executing analysismigration id : ".$analysis->analysis_id;
                                $live_analysis = new Analysis;
                                $live_analysis->attributes = $analysis->attributes;
                                $live_analysis->sample_id= $live_sample->sample_id;
                                if($live_analysis->is_package>0){
                                    $live_analysis->is_package=1;
                                }
                                $live_analysis->save(false);
                            }

                        }

                    }


                }

                $request->is_migrated=1;
                if($request->save()){
                    $Transaction->commit();
                }else{
                     $Transaction->rollback();
                }
                echo " \n Setting foreign_key_checks to 1";
                $Connection->createCommand('set foreign_key_checks=1')->execute();
                echo " \n \n Execution done on requestmigration id : ".$request->request_id;
                echo " \n \n**************************   ";
                
            } catch (Exception $e) {
                  $Transaction->rollback();
                   echo "Transaction rollback in request id : ".$request->request_id;
                  echo " \n Setting foreign_key_checks to 1";
                  $Connection->createCommand('set foreign_key_checks=1')->execute();
                  
            }
        }

        echo " \n \n Job Done";

    }
    
    public function actionCreate($message = 'hello world')
    {
        echo $message . "\n";
    }

}