<?php

namespace frontend\modules\referrals\controllers;

use Yii;
//use common\models\referral\Bidnotification;
//use common\models\referral\BidnotificationSearch;
//use common\models\referral\Referral;
//use common\models\referral\Agency;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\components\ReferralComponent;
use yii\data\ArrayDataProvider;

/**
 * BidnotificationController implements the CRUD actions for Bidnotification model.
 */
class BidnotificationController extends Controller
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
     * Lists all Bidnotification models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
            $function= new ReferralComponent();
			$bidnotification = json_decode($function->getBidNotificationAll($rstlId),true);
            $count = $bidnotification['count_bidnotification'];
        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }

        $list = [];
        if($count > 0){
			$notice_list = $bidnotification['bidnotification'];
            foreach ($notice_list as $data) {
                //$bid_notification_type = $data['bid_notification_type_id'];
                switch($data['bid_notification_type_id']){
                    case 1:
                        $agencyName = $this->getAgency($data['postedby_agency_id']);
                        $checkOwner = $function->checkowner($data['referral_id'],$rstlId);
                        $arr_data = ['notice_sent'=>"<b>".$agencyName."</b> notified a referral request for bidding.",'notice_id'=>$data['bid_notification_id'],'notification_date'=>$data['posted_at'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'seen'=>$data['seen']];
						//,'local_request_id'=>$data->referral->local_request_id,'seen'=>$data->seen];
                    break;
                    case 2:
                        $agencyName = $this->getAgency($data['postedby_agency_id']);
                        $checkOwner = $function->checkowner($data['referral_id'],$rstlId);
                        $arr_data = ['notice_sent'=>"<b>".$agencyName."</b> placed bids to the notified referral request.",'notice_id'=>$data['bid_notification_id'],'notification_date'=>$data['posted_at'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner,'seen'=>$data['seen']];
						//,'local_request_id'=>$data->referral->local_request_id,'seen'=>$data->seen];
                    break;
                }
                array_push($list, $arr_data);
            }
        } else {
            $list = [];
        }

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
            return $this->renderAjax('bidnotifications_all', [
                'notifications' => $list,
                'count_notice' => $count,
                'notificationProvider' => $notificationDataProvider,
            ]);
        } else {
            return $this->render('bidnotifications_all', [
                'notifications' => $list,
                'count_notice' => $count,
                'notificationProvider' => $notificationDataProvider,
            ]);
        }
    }

    //get unseen bid notifications
    public function actionCount_unseen_bidnotification()
    {
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
            $function = new ReferralComponent();
            $count_all_notifications = $function->countAllNotification($rstlId);
            $bidNotification = $function->listUnseenBidNofication($rstlId);
			
			if($bidNotification == false){
				return Json::encode(['bid_notification'=>null,'all_notifications'=>null]);
			} else {
				return Json::encode(['bid_notification'=>$bidNotification['count_bidnotification'],'all_notifications'=>$count_all_notifications]);
			}
        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }
    }

    //get list of unresponded notifications
    public function actionList_unseen_bidnotification()
    {
        if(isset(Yii::$app->user->identity->profile->rstl_id)){
            $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
            $function= new ReferralComponent();
			$bidnotification = json_decode($function->listUnseenBidNofication($rstlId),true);
        } else {
            //return 'Session time out!';
            return $this->redirect(['/site/login']);
        }
		
		$unseen_bidnotification = !empty($bidnotification['bidnotification']) ? $bidnotification['bidnotification'] : null;

        $notice_list = [];
        if(count($unseen_bidnotification) > 0) {
            foreach ($unseen_bidnotification as $data) {
                switch($data['bid_notification_type_id']){
                    case 1:
                        $agencyName = $this->getAgency($data['postedby_agency_id']);
                        $checkOwner = $function->checkowner($data['referral_id'],$rstlId);
                        $arr_data = ['notice_sent'=>"<b>".$agencyName."</b> notified a referral request for bidding.",'notice_id'=>$data['bid_notification_id'],'notification_date'=>$data['posted_at'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner];
						//,'local_request_id'=>$data->referral->local_request_id];
                    break;
                    case 2:
                        $agencyName = $this->getAgency($data['postedby_agency_id']);
                        $checkOwner = $function->checkowner($data['referral_id'],$rstlId);
                        $arr_data = ['notice_sent'=>"<b>".$agencyName."</b> placed bids to the notified referral request.",'notice_id'=>$data['bid_notification_id'],'notification_date'=>$data['posted_at'],'referral_id'=>$data['referral_id'],'owner'=>$checkOwner];
						//,'local_request_id'=>$data->referral->local_request_id];
                    break;
                }
                array_push($notice_list, $arr_data);
            }
        } else {
            $notice_list = [];
        }

        if(\Yii::$app->request->isAjax){
            return $this->renderAjax('list_unseen_bidnotification', [
                //'notifications' => $unseen_notification,
                'notifications' => $notice_list,
            ]);
        }
    }
	//get list agencies
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
}
