<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

use common\components\OldreferralComponent;

/**
 * AnalysisController implements the CRUD actions for Analysis model.
 */
class AnalysisController extends Controller
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
     * Lists all Analysis models.
     * @return mixed
     */
    public function actionIndex()
    {
        return false;
    }

    /**
     * Displays a single Analysis model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return false;
    }

    /**
     * Creates a new Analysis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $oldreferralcomp = new OldreferralComponent;
        $model = $oldreferralcomp->newanalysis(); //to continue

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $response = $oldreferralcomp->saveanalysis($model);
     
            
            if($response== true){
                //redirect to the newly created referral
                Yii::$app->session->setFlash('success', "New Test/s successfully created!");
                 return $this->redirect(['/referrals/referral/view?id='.$id]);
            }else{
                Yii::$app->session->setFlash('error', "A Test failed, Please contact administrator!");
                 return $this->redirect(['/referrals/referral/view?id='.$id]);
            }

        }

        $result = $oldreferralcomp->createanalysis($id);
        if(!$result){
            Yii::$app->session->setFlash('error', "Can't create new sample, Please contact administrator!");
            return $this->redirect(['/referrals/referral/view?id='.$id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'data'=>$result,
            'referral_id'=>$id
        ]);
    }

    public function actionTestnames($sample_ids){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $oldreferralcomp = new OldreferralComponent;
        $result=[];
        if(Yii::$app->request->get('sample_ids'))
        {
            $oldreferralcomp = new OldreferralComponent;
            $data = $oldreferralcomp->testnames($sample_ids);
            // return $data;

            if($data){
                    foreach ($data as $datum=>$key) {
                   $result[] = ['id'=>$datum,'text'=>$key] ;
                }
            }
        } else {
            $data = 'No sample selected.';
        }
        return $result;
    }

    public function actionMethods($test){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $oldreferralcomp = new OldreferralComponent;
        if(Yii::$app->request->get('test'))
        {
            $oldreferralcomp = new OldreferralComponent;
            $data = $oldreferralcomp->methods($test);

            if($data){
                 $methodrefDataProvider = new ArrayDataProvider([
                    'allModels' => $data,
                    'pagination' => false,
                ]);


                return $this->renderAjax('_methodreference', [
                    'methodrefDataProvider'=>$methodrefDataProvider,
                ]);
            } 
            
        }
        return 'No Testname Selected';
    }

    /**
     * Updates an existing Analysis model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        return false;
    }

    /**
     * Deletes an existing Analysis model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$refid)
    {
        $oldreferralcomp = new OldreferralComponent;
        $response=$oldreferralcomp->deleteanalysis($id);
		if($response == true){
			Yii::$app->session->setFlash('warning', 'Successfully Deleted.');
			return $this->redirect(['/referrals/referral/view', 'id' => $refid]); 
		}else{
			Yii::$app->session->setFlash('error', "Failed, Please contact administrator!");
			 return $this->redirect(['/referrals/referral/view?id='.$refid]);
		}   
        
    }

    /**
     * Finds the Analysis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Analysis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Analysis::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
