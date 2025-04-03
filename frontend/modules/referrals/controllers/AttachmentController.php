<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use common\models\referral\Attachment;
use common\models\referral\AttachmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;
use common\models\lab\exRequestreferral;
use common\components\ReferralComponent;
use linslin\yii2\curl;

/**
 * AttachmentController implements the CRUD actions for Attachment model.
 */
class AttachmentController extends Controller
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
     * Lists all Attachment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttachmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Attachment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Attachment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Attachment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->attachment_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Attachment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->attachment_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Attachment model.
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
     * Finds the Attachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attachment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attachment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	//upload Deposit Slip
	public function actionUpload_deposit()
    {
        set_time_limit(120);

        if(Yii::$app->request->get('referral_id')){
            $referralId = (int) Yii::$app->request->get('referral_id');
        } else {
            Yii::$app->session->setFlash('error', "Referral ID not valid!");
            return $this->redirect(['/lab/request']);
        }

        $requestId = (int) Yii::$app->request->get('request_id');

        $request = $this->findRequest($requestId);

        $model = new Attachment();
        if($model->load(Yii::$app->request->post())){
        //if(Yii::$app->request->post()){
            $model->filename = UploadedFile::getInstances($model,'filename');
            //$model->filetype = 1;
            $model->referral_id = $referralId;

            if($model->filename){

                $ch = curl_init();
                $referralCode = $request->request_ref_num;
                foreach ($model->filename as $filename) {
                    $file = $referralCode."_".date('YmdHis').".".$filename->extension; //.".".$filename->extension;
                    $file_data = curl_file_create($filename->tempName,$filename->type,$file);

                    $mi = !empty(Yii::$app->user->identity->profile->middleinitial) ? " ".substr(Yii::$app->user->identity->profile->middleinitial, 0, 1).". " : " "; 
                    $uploaderName = Yii::$app->user->identity->profile->firstname.$mi.Yii::$app->user->identity->profile->lastname;

                    $uploader_data = [
                        'file_name' => $referralCode."_".date('YmdHis').".".$filename->extension,
                        'referral_id' => $referralId,
                        'referral_code' => $referralCode,
                        'user_id' => Yii::$app->user->identity->profile->user_id,
                        'uploader' => $uploaderName,
                    ];
                    $referralUrl='https://eulimsapi.onelab.ph/api/web/referral/attachments/upload_deposit';

                    $data = ['file_data'=>$file_data,'uploader_data'=>json_encode($uploader_data)];

                    //hardcoded curl since the extension doesn't support create file
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $referralUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

                    $response = curl_exec($ch);

                    if($response == 1){
                        Yii::$app->session->setFlash('success', "Deposit slip successfully uploaded.");
                        return $this->redirect(['/lab/request/view','id'=>$requestId]);
                    } elseif($response == 0) {
                        Yii::$app->session->setFlash('error', "Attachment invalid!");
                        return $this->redirect(['/lab/request/view','id'=>$requestId]);
                    } else {
                        Yii::$app->session->setFlash('error', "Can't upload attachment!");
                        return $this->redirect(['/lab/request/view','id'=>$requestId]);
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', "Not valid upload attachment!");
                return $this->redirect(['/lab/request/view','id'=>$requestId]);
            }
        }
        
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_formUploadDeposit', [
                'model' => $model,
            ]);
        }
    }
	//upload Official Receipt
    public function actionUpload_or()
    {
        set_time_limit(120);

        if(Yii::$app->request->get('referral_id')){
            $referralId = (int) Yii::$app->request->get('referral_id');
        } else {
            Yii::$app->session->setFlash('error', "Referral ID not valid!");
            return $this->redirect(['/lab/request']);
        }

        $requestId = (int) Yii::$app->request->get('request_id');
        $request = $this->findRequest($requestId);


        $model = new Attachment();
        if($model->load(Yii::$app->request->post())){
            $model->filename = UploadedFile::getInstances($model,'filename');
            $model->referral_id = $referralId;
            if($model->filename){
                $ch = curl_init();
                $referralCode = $request->request_ref_num;
                foreach ($model->filename as $filename) {
                    $file = $referralCode."_".date('YmdHis').".".$filename->extension;
                    $file_data = curl_file_create($filename->tempName,$filename->type,$file);

                    $mi = !empty(Yii::$app->user->identity->profile->middleinitial) ? " ".substr(Yii::$app->user->identity->profile->middleinitial, 0, 1).". " : " "; 
                    $uploaderName = Yii::$app->user->identity->profile->firstname.$mi.Yii::$app->user->identity->profile->lastname;

                    $uploader_data = [
                        'file_name' => $referralCode."_".date('YmdHis').".".$filename->extension,
                        'referral_id' => $referralId,
                        'referral_code' => $referralCode,
                        'user_id' => Yii::$app->user->identity->profile->user_id,
                        'uploader' => $uploaderName,
                    ];
                    $referralUrl='https://eulimsapi.onelab.ph/api/web/referral/attachments/upload_or';

                    $data = ['file_data'=>$file_data,'uploader_data'=>json_encode($uploader_data)];

                    //hardcoded curl since the extension doesn't support create file
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $referralUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

                    $response = curl_exec($ch);

                    if($response == 1){
                        Yii::$app->session->setFlash('success', "Official receipt successfully uploaded.");
                        return $this->redirect(['/lab/request/view','id'=>$requestId]);
                    } elseif($response == 0) {
                        Yii::$app->session->setFlash('error', "Attachment invalid!");
                        return $this->redirect(['/lab/request/view','id'=>$requestId]);
                    } else {
                        Yii::$app->session->setFlash('error', "Can't upload attachment!");
                        return $this->redirect(['/lab/request/view','id'=>$requestId]);
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', "Not valid upload attachment!");
                return $this->redirect(['/lab/request/view','id'=>$requestId]);
            }
        }
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_formUploadOR', [
                'model' => $model,
            ]);
        }
    }
	//upload Test Result
    public function actionUpload_result()
    {
        $model = new Attachment();
        
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_formUploadResult', [
                'model' => $model,
            ]);
        }
    }

    //for download attachment type deposit slip, official receipt, test result
    public function actionDownload()
    {
        set_time_limit(120);

        if(Yii::$app->request->get('request_id')){
            $requestId = (int) Yii::$app->request->get('request_id');
        } else {
            Yii::$app->session->setFlash('error', "Request not valid!");
            return $this->redirect(['/lab/request']);
        }

        if(Yii::$app->request->get('file')){
            $fileId = (int) Yii::$app->request->get('file');
        } else {
            Yii::$app->session->setFlash('error', "Not a valid file!");
            return $this->redirect(['/lab/request/view','id'=>$requestId]);
        }

        if($fileId > 0){
            $request = $this->findRequest($requestId);
            //$referencenum = $request->request_ref_num;
            $refcomp = new ReferralComponent();

            $file_download = $refcomp->downloadAttachment($request->referral_id,Yii::$app->user->identity->profile->rstl_id,$fileId);
            //$filename = Yii::$app->request->get('file_name');


            //print_r($file_download);
            //exit;

            if($file_download == 'false'){
                Yii::$app->session->setFlash('error', "Can't download file!");
                return $this->redirect(['/lab/request/view','id'=>$requestId]);
            } else {
                //$checkMissing = json_decode($file_download);
                //print_r($file_download);
                //exit;
                //if($file_download != 0){
                    //return $this->redirect($file_download);
                //} else {
                    //return $this->redirect($file_download);
                //    Yii::$app->session->setFlash('error', "File is missing!");
                //    return $this->redirect(['/lab/request/view','id'=>$requestId]);
                //}
                return $this->redirect($file_download);
            }
        }
    }
    //find request
    protected function findRequest($id)
    {
        $model = exRequestreferral::find()->where(['request_id'=>$id,'request_type_id'=>2])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested Request its either does not exist or you have no permission to view it.');
        }
    }
}
