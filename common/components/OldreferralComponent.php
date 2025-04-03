<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use linslin\yii2\curl;
use yii\helpers\Json;
use yii\helpers\Html;

//referral
use common\models\oldreferral\Referral;
use common\models\oldreferral\Sample;
use common\models\oldreferral\Analysis;
use common\models\system\Profile;
use common\models\oldreferral\Customer;






/**
 * Description of Referral Component
 * Get Data from Referral API for local eULIMS
 * @author OneLab
 */
class OldreferralComponent extends Component {

    public $source="";

    function init(){
        $this->source = 'https://eulims.onelab.ph/api/restoldreferral';
        // $this->source = 'http://www.eulims.local/api/restoldreferral'; //incase you need to get the api somewhere

        if(!isset($_SESSION['usertoken'])){
            echo Html::button('Please login to access the Synching thru API', ['value'=>'/chat/info/login', 'class' => 'btn btn-lg btn-info','title' => Yii::t('app', "Login"),'id'=>'btnOP','onclick'=>'LoadModal(this.title, this.value,"100px","300px");']);
            exit();
        }
    }

    function customreturn($response){

        if(is_array($response)){

            if(isset($response['name'])&&isset($response['message'])&&isset($response['type'])){
                echo "<h1>".$response['name']."</h1>";
                echo "<hint>";
                echo $response['message'];
                echo "</hint>";
                exit;                
            }
        }

        return true;
    }

    /**
     * Get Source
     * @return string
     */
    function getSource(){
        return $this->source;
    }
    //provides model
    function newreferral(){ 
        $model = new Referral;
        $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
        if($profile){
            $model->receivedBy=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
        }else{
            $model->receivedBy="";
        }
        $model->referralCode="";
        $model->discount_id=1;
        $model->receivingAgencyId =  Yii::$app->user->identity->profile->rstl_id;
        $model->create_time = date("Y-m-d H:i:s");
        $model->cancelled=0;
        $model->state=0;
        $model->validation_status=0;
        $model->status=0;
        $model->acceptingAgencyId=0;
        $model->accepting_id=0;
        $model->gratis=0;
        $model->sampleArrivalDate = date('Y-m-d');
        $model->referralTime=date('h:i a');

        return $model;
    }

    //provides data for the new form
    function createreferral(){
       
        $apiUrl=$this->source.'/createreferral';
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        return $result;
    }

    function printreferral($id){
       
        $apiUrl=$this->source.'/print?id='.$id;
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);
        return $result;
    }

    //save the data from the form
    function savereferral($model){
        $data = Json::encode(['Referral'=>$model],JSON_NUMERIC_CHECK);
        $apiUrl=$this->source.'/savereferral';
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setRequestBody($data);
        $response = $curl->post($apiUrl);
        $result = json_decode($response);
        return $result;
    }

    function viewReferral($id){
        $apiUrl=$this->source.'/viewreferral?id='.$id;

        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        if(!$result){
            return false;
        }
        return $result;
    }

    function referrals($model){
        $data = Json::encode(['Data'=>$model],JSON_NUMERIC_CHECK);
        $apiUrl=$this->source.'/referrals';
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setRequestBody($data);
        $list = $curl->post($apiUrl);
        $result = json_decode($list);

        return $result;
    }

    function referralreport($model){
        $data = Json::encode(['Data'=>$model],JSON_NUMERIC_CHECK);
        $apiUrl=$this->source.'/referralreport';
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setRequestBody($data);
        $list = $curl->post($apiUrl);
        $result = json_decode($list);

        return $result;
    }

    function referralfigures($type,$ids,$rstl_id){

        switch ($type) {
            case 1:
                $apiUrl=$this->source.'/totalrl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;
            case 2:
                $apiUrl=$this->source.'/samplesrl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;
             case 3:
                $apiUrl=$this->source.'/testsrl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;
            case 4:
                $apiUrl=$this->source.'/totaltcl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;
            case 5:
                $apiUrl=$this->source.'/samplestcl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;
            case 6:
                $apiUrl=$this->source.'/teststcl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;
            case 7:
                $apiUrl=$this->source.'/feestcl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;
            case 8:
                $apiUrl=$this->source.'/gratistcl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;
            case 9:
                $apiUrl=$this->source.'/discountstcl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;
            case 10:
                $apiUrl=$this->source.'/grosstcl?ids='.$ids.'&rstl_id='.$rstl_id;
                break;

            
            default:
                return "error";
                break;
        }
        
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        return $result;
    }    

     function newsample($id){
        $model = new Sample;
        $model->referral_id=$id; 
        $model->barcode = "";
        $model->sampleName = "";
        $model->sampleCode ="";
        $model->description = "";
        $model->status_id =0;
        return $model;
    }

    function createsample($id){
        $apiUrl=$this->source.'/createsample?id='.$id;
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        return $result;
    }

    function savesample($model,$qnty){
        $data = Json::encode(['Sample'=>$model,'Qty'=>$qnty],JSON_NUMERIC_CHECK);
        $apiUrl=$this->source.'/savesample';
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setRequestBody($data);
        $response = $curl->post($apiUrl);
        $result = json_decode($response);
        return $result;
    }

     function newanalysis(){
        $model = new Analysis;
        $model->sample_id=0; 
        $model->testName_id = 0;
        $model->methodReference_id= 0;
        $model->package_id =0;
        $model->package = 0;
        $model->fee =0;
        $model->status_id=0;

        return $model;
    }

    function createanalysis($id){

        $apiUrl=$this->source.'/createanalysis?id='.$id;
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        return $result;
    }

    function saveanalysis($model){
        $data = Json::encode(['Analysis'=>$model],JSON_NUMERIC_CHECK);
        $apiUrl=$this->source.'/saveanalysis';
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setRequestBody($data);
        $response = $curl->post($apiUrl);
        $result = json_decode($response);
        return $result;
    }

    function testnames($sample_ids){

        $apiUrl=$this->source.'/testnames?sample_ids='.$sample_ids;
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        return $result;
    
    }

    function methods($test){

        $apiUrl=$this->source.'/methods?test='.$test;
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        return $result;
    
    }

    function networkagency($id){
        //id is referral id
        $apiUrl=$this->source.'/networkagency?referral_id='.$id;
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        return $result;
    }

    function notify($agency_id,$referral_id,$type){
        $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
        $name="";
        if($profile){
            //$name=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
            $name=$profile->lastname;
        }

        $apiUrl=$this->source.'/notify?agency_id='.$agency_id.'&referral_id='.$referral_id.'&type='.$type.'&sender_id='.Yii::$app->user->identity->profile->rstl_id.'&sender='.Html::encode($name);
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);
        return $result;
    }

     function confirm($agency_id,$referral_id,$type){

        $apiUrl=$this->source.'/confirm?agency_id='.$agency_id.'&referral_id='.$referral_id.'&type='.$type;
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        return $result;
    }

    function confirmaccept($referral_id){

        $apiUrl=$this->source.'/confirmaccept?agency_id='.Yii::$app->user->identity->profile->rstl_id.'&referral_id='.$referral_id;
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
        $result = json_decode($list);

        return $result;
    }

    function acceptreferral($model){

        $data = Json::encode(['Referral'=>$model],JSON_NUMERIC_CHECK);
        $apiUrl=$this->source.'/acceptreferral';
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setRequestBody($data);
        $response = $curl->post($apiUrl);
        $result = json_decode($response);
        return $result;
    }

    function sendreferral($model){

        $data = Json::encode(['Referral'=>$model],JSON_NUMERIC_CHECK);
        $apiUrl=$this->source.'/sendreferral';
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setRequestBody($data);
        $response = $curl->post($apiUrl);
        $result = json_decode($response);
        return $result;
    }

	function notification($rstlid){
       
        $apiUrl=$this->source.'/getnotification?rstlid='.$rstlid;
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $list = $curl->get($apiUrl);
       // $result = json_decode($list);

        return $list;
    }
	
	 //get only referral
    function getReferralOne($referralId,$rstlId)
    {
        if($referralId > 0){
            $apiUrl=$this->source.'/referral_one?referral_id='.$referralId.'&rstl_id='.$rstlId;
            $curl = new curl\Curl();
            $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
            $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
            $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
            $curl->setOption(CURLOPT_TIMEOUT, 180);
            $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
            $list = $curl->get($apiUrl);
            return Json::decode($list);
        } else {
            return 'Invalid referral!';
        }
    }
	 //get sample
    function getSample($sampleid)
    {
        if($sampleid > 0){
            $apiUrl=$this->source.'/getsample?sampleid='.$sampleid;
            $curl = new curl\Curl();
            $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
            $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
            $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
            $curl->setOption(CURLOPT_TIMEOUT, 180);
            $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
            $list = $curl->get($apiUrl);
            $result = json_decode($list);
			return $result;
        } else {
            return 'Invalid referral!';
        }
    }
	//update data model of Sample
	function updatesample($model){
        $data = Json::encode(['Sample'=>$model]);
        $apiUrl=$this->source.'/updatesample';
        $curl = new curl\Curl();
        $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setRequestBody($data);
        $response = $curl->post($apiUrl);
        $result = json_decode($response);
        return $result;
    }
	 //delete sample
    function deleteSample($sampleid)
    {
        if($sampleid > 0){
            $apiUrl=$this->source.'/deletesample?sampleid='.$sampleid;
            $curl = new curl\Curl();
            $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
            $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
            $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
            $curl->setOption(CURLOPT_TIMEOUT, 180);
            $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
            $list = $curl->get($apiUrl);
            $result = json_decode($list);
			return $result;
        } else {
            return 'Invalid referral!';
        }
    }
	//get analysis per sample
	function getAnalysis($sampleid)
    {
        if($sampleid > 0){
            $apiUrl=$this->source.'/getanalysis?sampleid='.$sampleid;
            $curl = new curl\Curl();
            $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
            $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
            $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
            $curl->setOption(CURLOPT_TIMEOUT, 180);
            $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
            $list = $curl->get($apiUrl);
            $result = json_decode($list);
			return $result;
        } else {
            return 'Invalid referral!';
        }
    }
	 //delete sample
    function deleteAnalysis($id)
    {
        if($id > 0){
            $apiUrl=$this->source.'/deleteanalysis?id='.$id;
            $curl = new curl\Curl();
            $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
            $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
            $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
            $curl->setOption(CURLOPT_TIMEOUT, 180);
            $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
            $list = $curl->get($apiUrl);
            $result = json_decode($list);
			return $result;
        } else {
            return 'Invalid referral!';
        }
    }
}

