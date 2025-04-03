<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\components\OldreferralComponent;

/**
 * SampleController implements the CRUD actions for Sample model.
 */
class SampleController extends Controller
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
     * Lists all Sample models.
     * @return mixed
     */
    public function actionIndex()
    {
        return false;
    }

    /**
     * Displays a single Sample model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return false;
    }


       /**
     * Creates a new Sample model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $oldreferralcomp = new OldreferralComponent;
        $model = $oldreferralcomp->newsample($id);

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $qnty = Yii::$app->request->post('qnty');


            $response = $oldreferralcomp->savesample($model,$qnty);

            
            if($response== true){
                //redirect to the newly created referral
                Yii::$app->session->setFlash('success', "New Sample/s successfully created!");
                 return $this->redirect(['/referrals/referral/view?id='.$id]);
            }else{
                Yii::$app->session->setFlash('error', "A Sample failed, Please contact administrator!");
                 return $this->redirect(['/referrals/referral/view?id='.$id]);
            }

        }

        $result = $oldreferralcomp->createsample($id);
        if(!$result){
            Yii::$app->session->setFlash('error', "Can't create new sample, Please contact administrator!");
            return $this->redirect(['/referrals/referral/view?id='.$id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'data'=>$result
        ]);
    }

    /**
     * Updates an existing Sample model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $oldreferralcomp = new OldreferralComponent;
		$model = $oldreferralcomp->newsample($id);
        $data = $oldreferralcomp->getsample($id);
		$refid=$data->referral_id;
		$result = $oldreferralcomp->createsample($refid);
		if ($model->load(Yii::$app->request->post())) {
			$model->id=$id;
            $response = $oldreferralcomp->updatesample($model);
            if($response == true){
                //redirect to the newly created referral
                Yii::$app->session->setFlash('success', "Sample successfully updated!");
                 return $this->redirect(['/referrals/referral/view?id='.$refid]);
            }else{
                Yii::$app->session->setFlash('error', "Failed, Please contact administrator!");
                 return $this->redirect(['/referrals/referral/view?id='.$refid]);
            }
			

        }
		
		 
		$model->sampleName=  $data->sampleName; 
        $model->description=  $data->description; 
		$model->sampleType_id=  $data->sampleType_id; 
		
        return $this->renderAjax('update', [
            'model' => $model,
			'data'=>$result
        ]);
    }

    /**
     * Deletes an existing Sample model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $oldreferralcomp = new OldreferralComponent;
		$data = $oldreferralcomp->getsample($id);
		$refid=$data->referral_id;
        $analyses = $oldreferralcomp->getanalysis($id);
        if(count($analyses) > 0){
			Yii::$app->session->setFlash('error', $data->sampleName." has analysis.\nRemove first the analysis then delete this sample.");
			return $this->redirect(['/referrals/referral/view', 'id' => $refid]);
        } else {
			$oldreferralcomp->deletesample($id);
			Yii::$app->session->setFlash('warning', 'Sample Successfully Deleted.');
            return $this->redirect(['/referrals/referral/view', 'id' => $refid]);
            
        }
    }

    /**
     * Finds the Sample model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sample the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sample::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
