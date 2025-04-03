<?php

namespace frontend\modules\api\controllers;

use \Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;


use common\models\oldreferral\Lab;
use common\models\oldreferral\Modeofrelease;
use common\models\oldreferral\Discount;
use common\models\oldreferral\Reasons;
use common\models\oldreferral\Purpose;
use common\models\oldreferral\Referral;
use common\models\oldreferral\Sampletype;
use common\models\oldreferral\Sample;
use common\models\oldreferral\Analysis;
use common\models\oldreferral\Agency;
use common\models\oldreferral\Testname;
use common\models\oldreferral\Methodreference;
use common\models\oldreferral\Service;
use common\models\oldreferral\Notification;
use common\models\oldreferral\Customer;

class RestoldreferralController extends \yii\rest\Controller
{
    public $serializer = [
        'class'=>'yii\rest\Serializer',
        'collectionEnvelope'=>'items',
    ];

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        return $this->serializeData($result);
    }

    protected function serializeData($data)
    {
        return Yii::createObject($this->serializer)->serialize($data);
    }

	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => ['getnotification','getsample'],
            'user'=> \Yii::$app->referralaccount,
        ];

        return $behaviors;
    }

    protected function verbs(){
        return [
            // 'login' => ['POST'],
            // 'user' => ['GET'],
        ];
    }

    public function actionIndex(){
        // return "Index";
        return new ActiveDataProvider([
            'query' => Referral::find(),
        ]);
    }
    
    public function actionCreatereferral(){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        return [
            'labs'=> $this->labs(),
            'modesofrelease'=>$this->modesofrelease(),
            'discounts'=> $this->discounts(),
            'reasons'=> $this->reasons(),
            'purposes'=>$this->purposes(),
        ];
    }

    public function actionPrint($id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;

        //get the referral record
        $referral =  Referral::find()
        ->select(['referral.*','receivingagency'=>'r.name','acceptingagency'=>'a.name','discountrate'=>'d.rate','fn.number','fn.revNum','fn.revDate'])
        ->with(['samples'=>function($query){
            $query->select(['sample.*','s.type']);
            $query->with(['analyses'=>function($query){
                $query->select(['analysis.*','mr.method','tn.testName']);
                $query->innerJoin(['mr' => 'methodreference'],'`analysis`.`methodReference_id` = `mr`.`id`');
                $query->innerJoin(['tn' => 'testname'],'`analysis`.`testName_id` = `tn`.`id`');
            }]);
            $query->innerJoin(['s' => 'sampletype'],'`sample`.`sampleType_id` = `s`.`id`');
        }])->innerJoin(['r' => 'agency'],'`referral`.`receivingAgencyId` = `r`.`id`')
        ->leftJoin(['a' => 'agency'],'`referral`.`acceptingAgencyId` = `a`.`id`')
        ->leftJoin(['d' => 'discount'],'`referral`.`discount_id` = `d`.`id`')
        ->leftJoin(['fn' => 'form_request'],'`referral`.`receivingAgencyId` = `fn`.`agency_id`')
        ->asArray()->where(['referral.id'=>$id])->one();

        //get the agency for the header
        $agency = Agency::find()
        ->select(['agency.*','r.*'])
        ->innerJoin(['r' => 'agency_details'],'`agency`.`id` = `r`.`agency_id`')
        ->where(['agency.id'=>$referral['receivingAgencyId']])->asArray()->one();

        return [
            'referral'=> $referral,
            'agency'=>$agency
        ];
    }

    public function actionSavereferral(){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON; 
        if(\Yii::$app->request->post('Referral')){
            $referral = \Yii::$app->request->post();
            
            //save the new customer
            $newcustomer = new customer;
            $newcustomer->customerName=$referral['Referral']['state'];
            $newcustomer->agencyHead=$referral['Referral']['state'];

            if(!$newcustomer->save(false)){
                return false;
            }
            //save new referral
            $newreferral = new referral;
            $newreferral->load($referral);
            $newreferral->customer_id = $newcustomer->id; 
            $newreferral->state=0; 
            if($newreferral->save(false)){
                return $newreferral->id;
            }
        }
        return false;
    }
    public function actionViewreferral($id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $connection = Yii::$app->oldreferraldb;
        return Referral::find()
        ->select(['referral.*','receivingagency'=>'r.name','acceptingagency'=>'a.name','customer_id'=>'c.customerName'])
        ->innerJoin(['r' => 'agency'],'`referral`.`receivingAgencyId` = `r`.`id`')
        ->leftJoin(['a' => 'agency'],'`referral`.`acceptingAgencyId` = `a`.`id`')
        ->leftJoin(['c' => 'customer'],'`referral`.`customer_id` = `c`.`id`')
        ->with(['samples'=>function($query){
            $query->select(['sample.*','s.type']);
            $query->with(['analyses'=>function($query){
                $query->select(['analysis.*','mr.method','tn.testName']);
                $query->innerJoin(['mr' => 'methodreference'],'`analysis`.`methodReference_id` = `mr`.`id`');
                $query->innerJoin(['tn' => 'testname'],'`analysis`.`testName_id` = `tn`.`id`');
            }]);
            $query->innerJoin(['s' => 'sampletype'],'`sample`.`sampleType_id` = `s`.`id`');
        }])->asArray()->where(['referral.id'=>$id])->one();
    }
    public function actionReferrals(){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON; 

        if(\Yii::$app->request->post('Data')){
            $model = \Yii::$app->request->post('Data');
            if($model['referralCode']){
                $query = Referral::find()
                ->select([
                    "referral.id",
                    "referralCode",
                    "referralDate",
                    "receivingagency"=>"r.name",
                    "acceptingagency"=>"a.name",
                    "customer_id"=>"c.customerName"
                ])
                ->innerJoin(['r' => 'agency'],'`referral`.`receivingAgencyId` = `r`.`id`')
                ->leftJoin(['a' => 'agency'],'`referral`.`acceptingAgencyId` = `a`.`id`')
                ->leftJoin(['c' => 'customer'],'`referral`.`customer_id` = `c`.`id`')
                ->where(['or',['receivingAgencyId'=>$model['rstl_id']],['acceptingAgencyId'=>$model['rstl_id']]])
                ->andWhere(['LIKE','referralCode',"%".$model['referralCode']."%",false])
                ->andWhere(['LIKE','referralDate','%'.$model['referralDate'].'%',false])
                ->orderBy('referralDate DESC')
                ->asarray()
                ->all();
            }else{
                $query = Referral::find()
                ->select([
                    "referral.id",
                    "referralCode",
                    "referralDate",
                    "receivingagency"=>"r.name",
                    "acceptingagency"=>"a.name",
                    "customer_id"=>"c.customerName"
                ])
                ->innerJoin(['r' => 'agency'],'`referral`.`receivingAgencyId` = `r`.`id`')
                ->leftJoin(['a' => 'agency'],'`referral`.`acceptingAgencyId` = `a`.`id`')
                ->leftJoin(['c' => 'customer'],'`referral`.`customer_id` = `c`.`id`')
                ->where(['receivingAgencyId'=>$model['rstl_id']])
                ->andWhere(['LIKE','referralDate','%'.$model['referralDate'].'%',false])
                ->orderBy('referralDate DESC')
                ->asarray()
                ->all();
            }            
        }else{
            $query = null;
        }

        return $provider = new ArrayDataProvider([
        'allModels' => $query,
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => [
            'attributes' => ['subcategoryName'],
        ],
    ]);
    }

     public function actionReferralreport(){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON; 
        $model=null;
        if(\Yii::$app->request->post('Data')){


            $model = \Yii::$app->request->post('Data');
            if($model['lab_id']){
                $query = Referral::find()
                ->select([ 
                    "mref"=> "DATE_FORMAT(referral.`referralDate`,'%m')",
                    "myear"=> "DATE_FORMAT(referral.`referralDate`,'%Y')",
                    "monthref"=> "DATE_FORMAT(referral.`referralDate`,'%M')",
                    "referrals"=> "count(referral.id)",
                    "g_id"=>"Group_concat(r.id)"
                ])
                 ->where(['and',['between', 'referralDate', $model['datefrom'], $model['dateto']],['<>','referralCode',""]])
                 ->andWhere(['or',['receivingAgencyId'=>$model['rstl_id']],['acceptingAgencyId'=>$model['rstl_id']]])
                ->andWhere(['lab_id'=>$model['lab_id']])
                ->andWhere(['status'=>0])
                ->groupBy('monthref')
                ->orderBy('myear DESC,mref ASC')
                ->asArray()->all();
            }else{
                $query = Referral::find()
                ->select([ 
                    "mref"=> "DATE_FORMAT(referral.`referralDate`,'%m')",
                    "myear"=> "DATE_FORMAT(referral.`referralDate`,'%Y')",
                    "monthref"=> "DATE_FORMAT(referral.`referralDate`,'%M')",
                    "referrals"=> "count(referral.id)",
                    "g_id"=>"Group_concat(id)"
                ])
                ->where(['and',['between', 'referralDate', $model['datefrom'], $model['dateto']],['<>','referralCode',""]])
                ->andWhere(['or',['receivingAgencyId'=>$model['rstl_id']],['acceptingAgencyId'=>$model['rstl_id']]])
                ->andWhere(['status'=>0])
                ->groupBy('monthref')
                ->orderBy('myear DESC, mref ASC')
                ->asArray()->all();
            }
        }else{
            $query = null;
        }


         return [
            'labs'=> $this->labs(),
            'model'=> $model,
            'dataprovider'=> $query
        ];
    }

    public function actionTotalrl($ids,$rstl_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ref_ids = explode(',', $ids);

        return Referral::find()
        ->where(['and',['receivingAgencyId'=>$rstl_id],['in','id',$ref_ids]])
        ->andWhere(['status'=>0])
        ->count();
    }

    public function actionSamplesrl($ids,$rstl_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ref_ids = explode(',', $ids);

        return Referral::find()
        ->select(['referralCode','s.id'])
         ->innerJoin(['s' => 'sample'],'`referral`.`id` = `s`.`referral_id`')
        ->where(['and',['receivingAgencyId'=>$rstl_id],['in','referral.id',$ref_ids]])
        ->andWhere(['status'=>0])
        ->count();
    }

     public function actionTestsrl($ids,$rstl_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ref_ids = explode(',', $ids);

         return Referral::find()
        ->select(['referralCode','s.id','a.fe'])
        ->innerJoin(['s' => 'sample'],'`referral`.`id` = `s`.`referral_id`')
        ->innerJoin(['a' => 'analysis'],'`s`.`id` = `a`.`sample_id`')
        ->where(['and',['receivingAgencyId'=>$rstl_id],['in','referral.id',$ref_ids]])
        ->andWhere(['!=','package','2'])
        ->andWhere(['status'=>0])
        ->count();

    }

    public function actionTotaltcl($ids,$rstl_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ref_ids = explode(',', $ids);

        return Referral::find()
        ->where(['and',['acceptingAgencyId'=>$rstl_id],['in','id',$ref_ids]])
        ->andWhere(['status'=>0])
        ->count();
    }

    public function actionSamplestcl($ids,$rstl_id){
       \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ref_ids = explode(',', $ids);

        return Referral::find()
        ->select(['referralCode','s.id'])
         ->innerJoin(['s' => 'sample'],'`referral`.`id` = `s`.`referral_id`')
        ->where(['and',['acceptingAgencyId'=>$rstl_id],['in','referral.id',$ref_ids]])
        ->andWhere(['status'=>0])
        ->count();
    }

    public function actionTeststcl($ids,$rstl_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ref_ids = explode(',', $ids);

         return Referral::find()
        ->select(['referralCode','s.id','a.fee'])
        ->innerJoin(['s' => 'sample'],'`referral`.`id` = `s`.`referral_id`')
        ->innerJoin(['a' => 'analysis'],'`s`.`id` = `a`.`sample_id`')
        ->where(['and',['acceptingAgencyId'=>$rstl_id],['in','referral.id',$ref_ids]])
        ->andWhere(['!=','package','2'])
        ->andWhere(['status'=>0])
        ->count();
    }

     public function actionFeestcl($ids,$rstl_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ref_ids = explode(',', $ids);
        //need to deduct the discount if there is any
        $recs =  Referral::find()
        ->select(['referralCode','discount_id','conforme'=>'sum(a.fee)','d.rate','actual'=>'(sum(a.fee)*((100-d.rate)*.01))'])
        ->innerJoin(['s' => 'sample'],'`referral`.`id` = `s`.`referral_id`')
        ->innerJoin(['a' => 'analysis'],'`s`.`id` = `a`.`sample_id`')
        ->leftJoin(['d' => 'discount'],'`referral`.`discount_id` = `d`.`id`')
        ->where(['and',['acceptingAgencyId'=>$rstl_id],['in','referral.id',$ref_ids]])
        ->andWhere(['referral.status'=>0,'gratis'=>0])
        ->groupBy('referralCode')
        ->asArray()
        ->all();
        // return $recs['actual'];
        $actual = 0;
        foreach ($recs as $rec) {
            $actual += $rec['actual']?$rec['actual']:$rec['conforme'];
        }
        return $actual;

    }

     public function actionGratistcl($ids,$rstl_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ref_ids = explode(',', $ids);

        $recs =  Referral::find()
        ->select(['referralCode','conforme'=>'sum(a.fee)'])
        ->innerJoin(['s' => 'sample'],'`referral`.`id` = `s`.`referral_id`')
        ->innerJoin(['a' => 'analysis'],'`s`.`id` = `a`.`sample_id`')
        ->where(['and',['acceptingAgencyId'=>$rstl_id],['in','referral.id',$ref_ids]])
        ->andWhere(['status'=>0,'gratis'=>1])
        ->asArray()
        ->one();
        if(isset($recs['conforme']))
            return $recs['conforme'];// return $recs->conforme;//temp assign sum to conforme
        else
            return 0;

    }

    public function actionDiscountstcl($ids,$rstl_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ref_ids = explode(',', $ids);
        //need to deduct the discount if there is any
        $recs =  Referral::find()
        ->select(['referralCode','discount_id','conforme'=>'sum(a.fee)','d.rate','actual'=>'(sum(a.fee)*(d.rate*.01))'])
        ->innerJoin(['s' => 'sample'],'`referral`.`id` = `s`.`referral_id`')
        ->innerJoin(['a' => 'analysis'],'`s`.`id` = `a`.`sample_id`')
        ->leftJoin(['d' => 'discount'],'`referral`.`discount_id` = `d`.`id`')
        ->where(['and',['acceptingAgencyId'=>$rstl_id],['in','referral.id',$ref_ids]])
        ->andWhere(['referral.status'=>0,'gratis'=>0])
        ->groupBy('referralCode')
        ->asArray()
        ->all();
        // return $recs['actual'];
        $actual = 0;
        foreach ($recs as $rec) {
            $actual +=$rec['actual']?$rec['actual']:0;
        }
        return $actual;
    }

     public function actionGrosstcl($ids,$rstl_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        // return "success";
        $ref_ids = explode(',', $ids);
        //need to deduct the discount if there is any
        $recs =  Referral::find()
        ->select(['referralCode','conforme'=>'sum(a.fee)'])
        ->innerJoin(['s' => 'sample'],'`referral`.`id` = `s`.`referral_id`')
        ->leftJoin(['a' => 'analysis'],'`s`.`id` = `a`.`sample_id`')
        ->where(['and',['acceptingAgencyId'=>$rstl_id],['in','referral.id',$ref_ids]])
        ->andWhere(['referral.status'=>0,'gratis'=>0])
        ->asArray()
        ->one();

         if(isset($recs['conforme']))
            return $recs['conforme'];
        else
            return 0;
    }



    public function actionCreatesample($id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $referral = Referral::findOne($id);
        return [
            'sampletype'=> $this->sampletypes($referral->lab_id),
        ];
    }

    public function actionSavesample(){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        if(\Yii::$app->request->post('Sample')&&\Yii::$app->request->post('Qty')){
            $sample = \Yii::$app->request->post();
            $qty = \Yii::$app->request->post('Qty');
            if((int)$qty ==1){
                $newsample = new Sample;
                $newsample->load($sample);
                if(!$newsample->save(false)){
                    return false;
                }
            }else{
                $i=1;
                while($i<=(int)$qty){
                    $newsample = new Sample;
                    $newsample->load($sample);
                    $newsample->sampleName .=" #".$i;
                    if(!$newsample->save(false)){
                        return false;
                    }
                    $i++;
                }
            }

            return true;
        }
        return false;
    }

    public function actionSaveanalysis(){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        if(\Yii::$app->request->post('Analysis')){
            $analysis = new Analysis;
            $analysis->load(\Yii::$app->request->post());
            foreach ($analysis->sample_id as $sampleId) {
                $newanalysis = new Analysis;
                $newanalysis->load(\Yii::$app->request->post());
                //get the fee
                $methodref = Methodreference::findOne($newanalysis->methodReference_id); 
                $newanalysis->sample_id=$sampleId;
                $newanalysis->fee = $methodref->fee; 
                if(!$newanalysis->save(false)){
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function actionCreateanalysis($id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $referral = Referral::findOne($id);
        return [
            'samples'=> $this->samples($id),
            'agencies'=> $this->agencies(),
        ];
    }

    /* Functions to set header with status code. eg: 200 OK ,400 Bad Request etc..*/        
    private function setHeader($status)
    {
      
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type="application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Nintriva <nintriva.com>");
    }

    private function _getStatusCodeMessage($status)
    {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
	public function actionGetnotification($rstlid){
        return [
            'notifications'=> $this->Countnotification($rstlid),
        ];

    }

    public function actionTestnames($sample_ids){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $samples = explode(",", $sample_ids);
        $sampletype_ids = [];
        foreach ($samples as $sample) {
            $thesample = Sample::findOne($sample);
            $sampletype_ids[] = $thesample->sampleType_id;
        }

        return ArrayHelper::map(Testname::find()
            ->leftJoin(['st' => 'sampletype_testname'],'`testname`.`id` = `st`.`testname_id`')
            ->where(['in','st.sampletype_id',$sampletype_ids])
            ->orderBy('testname.testName ASC')
            ->asArray()
            ->all(),
            'id','testName');
    }

     public function actionMethods($test){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
    
        return Methodreference::find()
            ->leftJoin(['tm' => 'testname_method'],'`methodreference`.`id` = `tm`.`method_id`')
            ->where(['tm.testname_id'=>$test])
            ->orderBy('method ASC')
            ->asArray()
            ->all();
    }

    public function actionNetworkagency($referral_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $referral = Referral::find()->where(['id'=>$referral_id])->with(['samples'=>function($query){
            $query->with('analyses');
        }])->asArray()->one();
        $test = [];

        foreach ($referral['samples'] as $sample) {
            foreach ($sample['analyses'] as $analysis ) {
                $test[] = $analysis['methodReference_id'];
            }
        }

        return Service::find()
        ->select(['service.*','a.region','a.name','a.code'])
        ->leftJoin(['a' => 'agency'],'`service`.`agency_id` = `a`.`id`')
        ->where(['in','method_ref_id',$test])
        ->groupBy('service.agency_id')
        ->asArray()->all();
                // ->andWhere(['n1.resource_id'=>$referral_id])
        // ->andWhere(['n2.resource_id'=>$referral_id])
    }

    public function actionNotify($agency_id,$referral_id,$type,$sender,$sender_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        //check if notification has been sent
        $not = Notification::find()->where(['resource_id'=>$referral_id,'type_id'=>$type,'recipient_id'=>$agency_id])->one();
        if($not){
            $not2 = Notification::find()->where(['resource_id'=>$referral_id,'type_id'=>2,'sender_id'=>$agency_id])->one();
            if($not2)
                return false;
            else{
                //update notification date
                $not->notificationDate = date('Y-m-d');
                if($not->save(false))
                    return true;
            }
        }else{
            $newnotif = new Notification;
            $newnotif->type_id = $type;
            $newnotif->recipient_id = $agency_id;
            $newnotif->sender_id=$sender_id;
            $newnotif->sender=$sender;
            $newnotif->message="";
            $newnotif->controller="referral";
            $newnotif->action="preview";
            $newnotif->resource_id=$referral_id;
            $newnotif->viewed =0;
            $newnotif->notificationDate=date('Y-m-d');
            if($newnotif->save(false))
                return true;
        }

         return false;
    }

    public function actionConfirm($agency_id,$referral_id,$type){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        //check if notification has been sent
        $not = Notification::find()->where(['resource_id'=>$referral_id,'type_id'=>$type,'sender_id'=>$agency_id])->one();
        if($not)
            return $not->message;
        else
            return false;
    }

    public function actionConfirmaccept($agency_id,$referral_id){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        //check if notification has been sent
        $not = Notification::find()->where(['resource_id'=>$referral_id,'type_id'=>1,'recipient_id'=>$agency_id])->one();
        if($not)
            return true;
        else
            return false;
    }

    public function actionAcceptreferral(){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON; 

        if(\Yii::$app->request->post('Referral')){
            $referral = \Yii::$app->request->post('Referral');
            //query the referral
            $model = Referral::findOne($referral['id']);
            //check notification
            $not = Notification::find()->where(['resource_id'=>$referral['id'],'type_id'=>2,'sender_id'=>$referral['receivingAgencyId']])->one();

            if($not){
                $not->message=$referral['reportDue'];
                $not->notificationDate=date('Y-m-d');
                if($not->save(false))
                    return $not->id;
            }
        
            //make new notification of type 3
            $newnotif = new Notification;
            $newnotif->type_id = 2;
            $newnotif->recipient_id = $model->receivingAgencyId;
            $newnotif->sender_id=$referral['receivingAgencyId']; //form was just reuse
            $newnotif->sender=$referral['receivedBy'];
            $newnotif->message=$referral['reportDue'];
            $newnotif->controller="referral";
            $newnotif->action="view";
            $newnotif->resource_id=$referral['id'];
            $newnotif->viewed =0;
            $newnotif->notificationDate=date('Y-m-d');
            if($newnotif->save(false))
                return $model->id;
            return false;           
        }
        return false;
    }

    public function actionSendreferral(){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON; 

        if(\Yii::$app->request->post('Referral')){
            $referral = \Yii::$app->request->post('Referral');
            //query the referral
            $model = Referral::findOne($referral['id']);
            if($model){
                //update the referral code ,referral date, due and accepting agency Id
                $model->reportDue = $referral['reportDue'];
                $model->referralDate = date('Y-m-d');
                $model->acceptingAgencyId = $referral['acceptingAgencyId'];
                $model->referralCode = Referral::generateReferralCode($model->lab_id,$model->id);
                //update the referral
                if($model->save(false)){
                    //make new notification of type 3
                    $newnotif = new Notification;
                    $newnotif->type_id = 3;
                    $newnotif->recipient_id = $model->acceptingAgencyId;
                    $newnotif->sender_id=$model->receivingAgencyId;
                    $newnotif->sender=$model->receivedBy;
                    $newnotif->message="";
                    $newnotif->controller="referral";
                    $newnotif->action="preview";
                    $newnotif->resource_id=$model->id;
                    $newnotif->viewed =0;
                    $newnotif->notificationDate=date('Y-m-d');
                    $newnotif->save(false);

                    return $model->id;
                }
            }
        }
        return false;
    }

    function agencies(){
        return ArrayHelper::map(Agency::find()->all(),'id','name');
    }

    function samples($referral_id){
        return ArrayHelper::map(Sample::find()->where(['referral_id'=>$referral_id])->all(),'id','sampleName');
    }

    function sampletypes($lab_id){
        $data = ArrayHelper::map(Sampletype::find()->leftJoin(['ls' => 'lab_sampletype'],'`sampletype`.`id` = `ls`.`sampletypeId`')->where(['ls.lab_id'=>$lab_id])->orderBy('sampletype.type ASC')->asArray()->all(),'id','type');
        return $data;
    }

    function labs(){
        $data = ArrayHelper::map(Lab::find()->all(),'id','labName');
        return $data;
    }

    function modesofrelease(){
        $data = ArrayHelper::map(Modeofrelease::find()->where(['status'=>1])->all(),'id','mode');
        return $data;
    }

    function discounts(){
        $data = ArrayHelper::map(Discount::find()->where(['status'=>1])->all(),'id',function($model){
            return $model->type." (".$model->rate.'%)';
        });
        return $data;
    }

    function reasons(){
        $data = ArrayHelper::map(Reasons::find()->all(),'reason','reason');
        return $data;
    }
    
    function purposes(){
        $data = ArrayHelper::map(Purpose::find()->where(['status'=>1])->all(),'id','name');
        return $data;   
    }
	
	
	public function Countnotification($rstl_id)
    {
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        if($rstl_id > 0){
            $model = new Notification;
            try {
                $query = $model::find()
                    ->where('recipient_id =:recipientId', [':recipientId'=>$rstl_id])
                    ->andWhere('viewed =:viewed',[':viewed'=>0]);

                $notificationCount = $query->count();
                $notification = $query->orderBy('notificationDate DESC')->all();

                if($notificationCount > 0){
                    return ['notification'=>$notification,'count_notification'=>$notificationCount];
                } else {
                    return ['notification'=>[],'count_notification'=>0];
                }
                
            } catch (Exception $e) {
                throw new \yii\web\HttpException(500, 'Internal server error');
            }
        } else {
            throw new \yii\web\HttpException(400, 'No records found');
        }
    }
	 public function actionReferral_one($referral_id,$rstl_id)
    {
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        try {
            $model = new Referral;
            
            $referral = $model::find()
                ->where('referral_id =:referralId', [':referralId'=>$referral_id])
                ->andWhere('receiving_agency_id =:receivingAgency OR testing_agency_id =:testingAgency', [':receivingAgency'=>$rstl_id,':testingAgency'=>$rstl_id])
                ->asArray()->one();
            
                return $referral;
        } catch (Exception $e) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }
    }
	
	
	public function actionGetsample($sampleid)
    {
		\Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $data = Sample::find()->where(['id'=>$sampleid])->One();
        return $data;   
    }
	//update sample
	 public function actionUpdatesample(){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        if(\Yii::$app->request->post('Sample')){
            $sample = \Yii::$app->request->post();
			$sampleid = $sample['Sample']['id'];
			$updatesample=Sample::find()->where(['id'=>$sampleid])->One();
            $updatesample->sampleName = $sample['Sample']['sampleName'];   
			$updatesample->sampleType_id = $sample['Sample']['sampleType_id']; 
			$updatesample->description = $sample['Sample']['description'];   
			
                if(!$updatesample->save(false)){
                    return false;
                }else{
					return true;
				}
           

            //return $updatesample->sampleName;
        }
        return false;
    }
	public function actionDeletesample($sampleid)
    {
		\Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $data = Sample::find()->where(['id'=>$sampleid])->One()->delete();
        return;   
    }
	public function actionGetanalysis($sampleid)
    {
		\Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $data = Analysis::find()->where(['sample_id'=>$sampleid])->All();
        return $data;   
    }
	public function actionDeleteanalysis($id)
    {
		\Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        try{
			$data = Analysis::find()->where(['id'=>$id])->One()->delete();
			return true;   
        }catch (Exception $e) {
			return false; 
		}
    }

}