<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\components\OldreferralComponent;
use common\components\Functions;
use yii\data\ArrayDataProvider;
use frontend\modules\referrals\template\Srchref;
use yii\helpers\Html;
use frontend\modules\referrals\template\Printreferral;
use common\models\lab\Customer;



/**
 * ReferralController implements the CRUD actions for Referral model.
 */
class ReferralController extends Controller
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

    public function beforeAction($action)
    {
        if(isset($_SESSION['usertoken'])){
            return parent::beforeAction($action);
        }
        return $this->redirect('/referrals/')->send();
     }

    /**
     * Lists all Referral models.
     * @return mixed
     */
    public function actionIndex()
    {
        $oldreferralcomp = new OldreferralComponent;
        $model = new Srchref;

        if ($model->load(Yii::$app->request->post())) {
            $searchref = Yii::$app->request->post('Srchref');
            $model->referralCode = $searchref['referralCode'];
            $model->referralDate= $searchref['referralDate'];
        }

        $dataProvider = $oldreferralcomp->referrals($model);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model'=>$model
        ]);
    }

    /**
     * Displays a single Referral model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $oldreferralcomp = new OldreferralComponent;
        $model = $oldreferralcomp->viewreferral($id);
        if(!$model){
            Yii::$app->session->setFlash('error', "Can't retrieve the referral with ID ".$id.", Please contact administrator!");
            return $this->redirect(['index']);
        }

        return $this->render('view', [
                'model'=>$model
            ]);
    }

    /**
     * Creates a new Referral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       $oldreferralcomp = new OldreferralComponent;
        $model = $oldreferralcomp->newreferral();
        
        if ($model->load(Yii::$app->request->post())) {
            // get the customer
            $cust = Customer::findOne($model->customer_id);
            $model['state']=$cust->customer_name;
            // var_dump($model); exit;
            $response = $oldreferralcomp->savereferral($model);
            // var_dump($response); exit;
            if($response== true){
                //redirect to the newly created referral
                Yii::$app->session->setFlash('success', "New referral successfully created!");
                return $this->redirect(['view', 'id' => $response]); ///lab/request/view?id=1
            }else{
                Yii::$app->session->setFlash('error', "New referral failed, Please contact administrator!");
                return $this->redirect(['index']);
            }
        }

        $result = $oldreferralcomp->createreferral();
        if(!$result){
            Yii::$app->session->setFlash('error', "Can't create new referral, Please contact administrator!");
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'data' => $result,
        ]);
    }

    public function actionAgencies($id){
        $oldreferralcomp = new OldreferralComponent;
        $result = $oldreferralcomp->networkagency($id);

        $agencyDataProvider = new ArrayDataProvider([
                    'allModels' => $result,
                    'pagination' => false,
                ]);

        return $this->renderAjax('_agencies', [
                    'agencies'=>$agencyDataProvider,
                    'referral_id'=>$id
                ]);
    }

    public function actionRefer($agency_id,$referral_id,$type){
        //send notification

        $oldreferralcomp = new OldreferralComponent;
        $result = $oldreferralcomp->notify($agency_id,$referral_id,$type);
        if(!$result){
            Yii::$app->session->setFlash('error', "Failed to notify, If you didn't notify them before please contact the administrator!");
        }else{
            Yii::$app->session->setFlash('success', "Notification Sent!");
        }
        return $this->redirect(['view', 'id' => $referral_id]);

    }

     public function actionConfirmed($agency_id,$referral_id,$type,$company = "this agency"){
        //send notification

        $oldreferralcomp = new OldreferralComponent;
        $result = $oldreferralcomp->confirm($agency_id,$referral_id,$type);
        if($result)
            return $result;

        $urls = '/referrals/referral/refer?agency_id='.$agency_id.'&referral_id='.$referral_id.'&type=1';
        return Html::a('<span class="fa fa-mail-forward"></span>  Send Notification', $urls,['data-confirm'=>"Are you sure you want to refer to <b>".$company."</b>?", 'data-method'=>'post', 'class'=>'btn btn-success','title'=>'Notify','data-pjax'=>'0']);

    }


     public function actionConfirmedsend($agency_id,$referral_id,$type,$company = "this agency"){
        //send notification

        $oldreferralcomp = new OldreferralComponent;
        $result = $oldreferralcomp->confirm($agency_id,$referral_id,$type);
        if($result)
            return "<button type='button' onclick='LoadModal(\"Send Referral\",\"/referrals/referral/sendreferral?agency_id=".$agency_id."&referral_id=".$referral_id."\")' class='btn btn-success'><i class='fa fa-book-o'></i> Send Referral</button>";

        return "Notify first";
        


    }

     public function actionConfirmedaccept($referral_id){
        //send notification

        $oldreferralcomp = new OldreferralComponent;
        $result = $oldreferralcomp->confirmaccept($referral_id);
        if($result)
            return "<button type='button' onclick='LoadModal(\"Accept Referral\",\"/referrals/referral/acceptreferral?agency_id=".Yii::$app->user->identity->profile->rstl_id."&referral_id=".$referral_id."\")' class='btn btn-success'><i class='fa fa-book-o'></i> Accept Referral</button>";

        return "Not Allowed to respond to this referral!";
        
    }

    public function actionAcceptreferral($agency_id,$referral_id){

        $oldreferralcomp = new OldreferralComponent;
        $model = $oldreferralcomp->newreferral();
        $model->id = $referral_id;
        $model->acceptingAgencyId = $agency_id;
        $model->referralDate = date('Y-m-d');

        if ($model->load(Yii::$app->request->post())) {

            $response = $oldreferralcomp->acceptreferral($model);
            if($response){
                //redirect to the newly created referral
                Yii::$app->session->setFlash('success', "Notification to Accept Referral Sent!");
                 return $this->redirect(['view', 'id' => $referral_id]);
            }else{
                Yii::$app->session->setFlash('error', "Failed to accept referral, Please contact administrator!");
                 return $this->redirect(['view', 'id' => $referral_id]);
            }
        }

        return $this->renderAjax('_accept', [
                    'model'=>$model
                ]);
    }

    public function actionSendreferral($agency_id,$referral_id){

        $oldreferralcomp = new OldreferralComponent;
        $model = $oldreferralcomp->newreferral();
        $model->id = $referral_id;
        $model->acceptingAgencyId = $agency_id;
        $model->referralDate = date('Y-m-d');

        if ($model->load(Yii::$app->request->post())) {

            $response = $oldreferralcomp->sendreferral($model);
            if($response){
                //redirect to the newly created referral
                Yii::$app->session->setFlash('success', "Referral successfully sent!");
                 return $this->redirect(['view', 'id' => $referral_id]);
            }else{
                Yii::$app->session->setFlash('error', "Referral failed to send, Please contact administrator!");
                 return $this->redirect(['view', 'id' => $referral_id]);
            }
        }

        return $this->renderAjax('_send', [
                    'model'=>$model
                ]);
    }


    /**
     * Updates an existing Referral model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
       
    }

    /**
     * Deletes an existing Referral model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Referral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Referral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Referral::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


 
    //find referral request
    protected function findRequest($id)
    {
        $model = exRequestreferral::find()->where(['request_id'=>$id,'request_type_id'=>2])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested Request its either does not exist or you have no permission to view it.');
        }
    }

    public function actionPrint($id){
        $Printing=new Printreferral();
        $Printing->Printing($id);
    }
}
