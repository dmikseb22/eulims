<?php 

namespace frontend\modules\api\controllers;

use yii\web\Controller;
use Yii;
use linslin\yii2\curl;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Restore_customer;
use yii\helpers\Json;

/**
 * Default controller for the `Lab` module
 */
class CustomerController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('backup_restore');

    }

    public function actionRestore(){
        $model = new Restore_customer();
        $rstl_id=$model->rstl_id=Yii::$app->user->identity->profile->rstl_id;
        $Url="https://api3.onelab.ph/get/customer/total-page?rstl_id=11&pp=10";
        $curl1 = new curl\Curl();
        $res1 = $curl1->get($Url);
        $page= round($res1/50);
        $exist=0;
        $not_exist=0;
        
        for($x=1;$x<=$page;$x++){
           $apiUrl="https://api3.onelab.ph/get/customer/view?rstl_id=11&page=$x&per-page=50";
            $curl = new curl\Curl();
            $res = $curl->get($apiUrl);
            $decode=Json::decode($res);
           
            foreach ($decode as $customer){
                $cust= Restore_customer::find()->where(['customer_code'=>$customer['customer_code']])->all();
                if($cust){
                   $exist++; 
                }
                else{
                    $model_customer = new Restore_customer();
                    $model_customer->rstl_id=$rstl_id;
                    $model_customer->customer_code=$customer['customer_code'];
                    $model_customer->customer_name=$customer['customer_name'];
                    $model_customer->classification_id=$customer['classification_id'];
                    $model_customer->latitude=$customer['latitude'];
                    $model_customer->longitude=$customer['longitude'];
                    $model_customer->head=$customer['head'];
                    $model_customer->barangay_id=$customer['barangay_id'];
                    $model_customer->address=$customer['address'];
                    $model_customer->tel=$customer['tel'];
                    $model_customer->fax=$customer['fax'];
                    $model_customer->email=$customer['email'];
                    $model_customer->customer_type_id=$customer['customer_type_id'];
                    $model_customer->business_nature_id=$customer['business_nature_id'];
                    $model_customer->industrytype_id=$customer['industrytype_id'];
                    $model_customer->created_at=$customer['created_at'];
                    $model_customer->customer_old_id=$customer['customer_id'];
                    $barangays=$customer['barangay'];
                    $model_customer->Oldcolumn_municipalitycity_id=$barangays['municipality_city_id'];
                    $model_customer->Oldcolumn_district=$barangays['district'];
                    $model_customer->save();
                    $not_exist++;
                }

            } 
        }
        
        
        Yii::$app->session->setFlash('success', $not_exist.' Records Successfully Restored'); 
        return $this->redirect(['index']);
    }


    public function actionCustomer()
    {
        return $this->render('customers');
    }
}