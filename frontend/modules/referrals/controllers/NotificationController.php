<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use common\models\referral\Notification;
use common\models\referral\NotificationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\exRequestreferral;
use yii\helpers\Json;
use common\components\ReferralComponent;
use common\components\OldreferralComponent;
use yii\data\ArrayDataProvider;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Notification models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new NotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = Yii::$app->user->identity->profile->rstl_id;

            $refcomponent = new OldreferralComponent();
            $notification = $refcomponent->Notification($rstlId);
			 $notif=json_decode(json_encode($notification), true);
			//$notif=json_decode($notification, true);
			
            //$count = $notification['count_notification'];
            $refcomponent = new ReferralComponent();
            $notification = json_decode($refcomponent->getNotificationAll($rstlId),true);
            $count = $notification['count_notification'];

        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }

        //$unresponded_notification = !empty($notification['notification']) ? $notification['notification'] : null;
        $list = [];

        //if($count > 0){
            
            foreach ($notif as $data) {
			  //var_dump($data);exit;
               // $notification_type = $data['notification_type_id'];
                $arr_data = [];
                switch($data[0]['type_id']){

        if($count > 0){
            $notice_list = $notification['notification'];
            foreach ($notice_list as $data) {
                $notification_type = $data['notification_type_id'];
                switch($data['notification_type_id']){

                    case 1:
                        $agencyName = $this->getAgency($data['sender_id']);
                        $referral = $this->getReferral($data['referral_id']);
                        $checkOwner = json_decode($refcomponent->checkOwner($data['referral_id'],$rstlId),true);
                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> notified a referral request.",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id']];
                    break;
                    case 2:
                        $agencyName = $this->getAgency($data['sender_id']);
                        $referral = $this->getReferral($data['referral_id']);

                        //$arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> confirmed the referral notification.",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id'],'responded'=>$data['responded']];
						$arr_data = ['notice_sent'=>"byeu",'notice_id'=>$data['id'],'notification_date'=>$data['notificationDate'],'referral_id'=>2,'owner'=>1,'local_request_id'=>3,'responded'=>2];
					break;

                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> confirmed the referral notification.",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id']];
                    break;

                    case 3:
                        $agencyName = $this->getAgency($data['sender_id']);
                        $referral = $this->getReferral($data['referral_id']);
                        $checkOwner = json_decode($refcomponent->checkOwner($data['referral_id'],$rstlId),true);

                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> sent a referral request with referral code <b style='color:#000099;'>".$referral['referralcode']."</b>",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id'],'responded'=>$data['responded']];
				//$arr_data = ['notice_sent'=>"<b>".$data['sender']."</b> of <b>"Hola"</b> confirmed the referral notification.",'notice_id'=>$data['id'],'notification_date'=>$data['notificationDate'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id'],'responded'=>$data['responded']];
                  

                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> sent a referral request with referral code <b style='color:#000099;'>".$referral['referralcode']."</b>",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id']];
                    break;
                }

                array_push($list, $arr_data);
            }
	}		
        /*} else {
                    break;
                }
            $list = [];
        }/*

        $notificationDataProvider = new ArrayDataProvider([
            //'key'=>'notification_id',
            //'allModels' => $notification['notification'],
            'allModels' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
            //'pagination'=>false,
        ]);


        if(\Yii::$app->request->isAjax){
            return $this->renderAjax('notifications_all', [
                //'notifications' => $list,
                'count_notice' => $count,
                'notificationProvider' => $notificationDataProvider,
            ]);
        } else {
            return $this->render('notifications_all', [
                'notifications' => $list,
                'count_notice' => $count,
                'notificationProvider' => $notificationDataProvider,
            ]);
        }
    }
    //get unresponded notifications
    public function actionCount_unresponded_notification()
    {   
        
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = Yii::$app->user->identity->profile->rstl_id;
            $refcomponent = new ReferralComponent();
            //$notification = json_decode($refcomponent->listUnrespondedNofication($rstlId));
            $notification = $refcomponent->listUnrespondedNofication($rstlId);
        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }
        //print_r($notification);
        //return Json::encode(['num_notification'=>$notification->count_notification]);
        return Json::encode(['num_notification'=>$notification->count_notification]);
    }
    //get list of unresponded notifications
    public function actionList_unresponded_notification()
    {
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = Yii::$app->user->identity->profile->rstl_id;
            $refcomponent = new ReferralComponent();
            $notification = json_decode($refcomponent->listUnrespondedNofication($rstlId),true);
        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }

        $unresponded_notification = !empty($notification['notification']) ? $notification['notification'] : null;

        $notice_list = [];
        if(count($unresponded_notification) > 0) {
            foreach ($unresponded_notification as $data) {

                $notification_type = $data['notification_type_id'];
                switch($data['notification_type_id']){
                    case 1:
                        $agencyName = $this->getAgency($data['sender_id']);
                        $referral = $this->getReferral($data['referral_id']);
                        $checkOwner = json_decode($refcomponent->checkOwner($data['referral_id'],$rstlId),true);
                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> notified a referral request.",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id']];
                    break;
                    case 2:
                        $agencyName = $this->getAgency($data['sender_id']);
                        $referral = $this->getReferral($data['referral_id']);
                        $checkOwner = json_decode($refcomponent->checkOwner($data['referral_id'],$rstlId),true);
                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> confirmed the referral notification.",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id']];
                    break;
                    case 3:
                        $agencyName = $this->getAgency($data['sender_id']);
                        $referral = $this->getReferral($data['referral_id']);
                        $checkOwner = json_decode($refcomponent->checkOwner($data['referral_id'],$rstlId),true);
                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> sent a referral request with referral code <b style='color:#000099;'>".$referral['referralcode']."</b>",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id']];
                    break;
                }
                array_push($notice_list, $arr_data);
            }
        } else {
            $notice_list = [];
        }

        if(\Yii::$app->request->isAjax){
            return $this->renderAjax('list_unresponded_notification', [
                //'notifications' => $unseen_notification,
                'notifications' => $notice_list,
            ]);
        }
    }
    //get list of all notifications
    /*public function actionNotification_all()
    {
        $rstlId = Yii::$app->user->identity->profile->rstl_id;
        $refcomponent = new ReferralComponent();
        $notification = json_decode($refcomponent->listUnrespondedNofication($rstlId),true);
    }*/
    //get list agencies
	}
    private function getAgency($agencyId)
    {   
        $refcomponent = new ReferralComponent();
        $agency = json_decode($refcomponent->listAgency($agencyId),true);

        if($agency != null){
            return $agency[0]['name'];
        } else {
            return null;
        }
    }
    //get referral code
    private function getReferral($referralId)
    {
        $refcomponent = new ReferralComponent();
        $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
        $referral = json_decode($refcomponent->getReferralOne($referralId,$rstlId),true);

        if($referral ==  0){
            return null;
        } else {
            return ['referralcode'=>$referral['referral_code'],'receiving_agency_id'=>$referral['receiving_agency_id'],'local_request_id'=>$referral['local_request_id']];
        }
    }
	 public function actionNotifpstc()
    {
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = Yii::$app->user->identity->profile->rstl_id;

            $refcomponent = new ReferralComponent();
            $notification = $refcomponent->NotificationAll($rstlId);
			$notif=json_decode(json_encode($notification), true);
            $refcomponent = new ReferralComponent();
            $notification = json_decode($refcomponent->getNotificationAll($rstlId),true);
            $count = $notification['count_notification'];

        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }

        $list = [];
            foreach ($notif as $data) {
                $arr_data = [];
                switch($data[0]['type_id']){

        if($count > 0){
            $notice_list = $notification['notification'];
            foreach ($notice_list as $data) {
                $notification_type = $data['notification_type_id'];
                switch($data['notification_type_id']){

                    case 1:
                        $agencyName = $this->getAgency($data['sender_id']);
                        $referral = $this->getReferral($data['referral_id']);
                        $checkOwner = json_decode($refcomponent->checkOwner($data['referral_id'],$rstlId),true);
                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> notified a referral request.",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id']];
                    break;
                    case 2:
                        $agencyName = $this->getAgency($data['sender_id']);
                        $referral = $this->getReferral($data['referral_id']);

                        //$arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> confirmed the referral notification.",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id'],'responded'=>$data['responded']];
						$arr_data = ['notice_sent'=>"byeu",'notice_id'=>$data['id'],'notification_date'=>$data['notificationDate'],'referral_id'=>2,'owner'=>1,'local_request_id'=>3,'responded'=>2];
					break;

                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> confirmed the referral notification.",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id']];
                    break;

                    case 3:
                        $agencyName = $this->getAgency($data['sender_id']);
                        $referral = $this->getReferral($data['referral_id']);
                        $checkOwner = json_decode($refcomponent->checkOwner($data['referral_id'],$rstlId),true);

                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> sent a referral request with referral code <b style='color:#000099;'>".$referral['referralcode']."</b>",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id'],'responded'=>$data['responded']];
				//$arr_data = ['notice_sent'=>"<b>".$data['sender']."</b> of <b>"Hola"</b> confirmed the referral notification.",'notice_id'=>$data['id'],'notification_date'=>$data['notificationDate'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id'],'responded'=>$data['responded']];
                  

                        $arr_data = ['notice_sent'=>"<b>".$data['sender_name']."</b> of <b>".$agencyName."</b> sent a referral request with referral code <b style='color:#000099;'>".$referral['referralcode']."</b>",'notice_id'=>$data['notification_id'],'notification_date'=>$data['notification_date'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'local_request_id'=>$referral['local_request_id']];
                    break;
                }

                array_push($list, $arr_data);
            }
		}		
      
	}
}
