<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use common\models\referral\Service;
use common\models\referral\ServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Request;
use common\components\ReferralComponent;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use linslin\yii2\curl;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
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
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new ServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
        set_time_limit(120);
        $refcomponent = new ReferralComponent();

        $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;

        $labreferral = ArrayHelper::map(json_decode($refcomponent->listLabreferral()), 'lab_id', 'labname');

        //$referralDataprovider = new ArrayDataProvider([
            //'allModels' => $referrals,
            //'pagination'=> ['pageSize' => 10],
        //]);

        //return $this->render('index', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $referralDataprovider,
        //]);

        if(Yii::$app->request->get('testname_id')>0 && Yii::$app->request->get('sampletype_id')>0 && Yii::$app->request->get('lab_id')>0){
            $testnameId = (int) Yii::$app->request->get('testname_id');
            $sampletypeId = (int) Yii::$app->request->get('sampletype_id');
            $labId = (int) Yii::$app->request->get('lab_id');
            $methods = json_decode($this->listReferralmethodref($labId,$sampletypeId,$testnameId),true);
        } else {
            $methods = [];
        }

        $methodrefDataProvider = new ArrayDataProvider([
            //'key'=>'sample_id',
            'allModels' => $methods,
            'pagination' => [
                'pageSize' => 10,
            ],
            //'pagination'=>false,
        ]);

        return $this->render('index',[
            'laboratory' => $labreferral,
            'sampletype' => [],
            'testname' => [],
            'methodrefDataProvider' => $methodrefDataProvider,
            'count_methods' => count($methods),
        ]);
    }

    //agency offer service
    public function actionOffer()
    {
        set_time_limit(120);
        $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
        $data = Json::encode(['methodref_ids'=>Yii::$app->request->post('methodref_ids'),'lab_id'=>Yii::$app->request->post('lab_id'),'sampletype_id'=>Yii::$app->request->post('sampletype_id'),'testname_id'=>Yii::$app->request->post('testname_id'),'rstl_id'=>$rstlId],JSON_NUMERIC_CHECK);

        /*$referralUrl='https://eulimsapi.onelab.ph/api/web/referral/services/offer';
       
        $curl = new curl\Curl();
        $referralreturn = $curl->setRequestBody($data)
        ->setHeaders([
            'Content-Type' => 'application/json',
            'Content-Length' => strlen($data),
        ])->post($referralUrl);*/
        $refcomponent = new ReferralComponent();
        $postAPI = $refcomponent->offerService($data);

        //if($postAPI === 1){
            //Yii::$app->session->setFlash('success', "Sample Successfully Created.");
            //return $this->redirect(['/referrals/service']);
            //return "<div class='alert alert-success'>Successfully offered service.</div>";
            //return 1;
        //} else {
            //return "<div class='alert alert-error'>Offer not successful!</div>";
            //return "<div class='alert alert-success'>Successfully offered service.</div>";
           // return "Offer not successful!";
        //}
        //return 2 is duplicate
        //return 1 is success
        //return 0 is fail save
        return $postAPI;
    }
    //agency offer service
    public function actionRemove()
    {
        set_time_limit(120);
        $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
        $data = Json::encode(['methodref_ids'=>Yii::$app->request->post('methodref_ids'),'lab_id'=>Yii::$app->request->post('lab_id'),'sampletype_id'=>Yii::$app->request->post('sampletype_id'),'testname_id'=>Yii::$app->request->post('testname_id'),'rstl_id'=>$rstlId],JSON_NUMERIC_CHECK);

        $refcomponent = new ReferralComponent();
        $postAPI = $refcomponent->removeService($data);

        //print_r($postAPI);
        return $postAPI;
    }

    /**
     * Displays a single Service model.
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
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Service();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->service_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->service_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Service model.
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
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionList_sampletype() {
        $refcomponent = new ReferralComponent();
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = (int) end($_POST['depdrop_parents']);
            //$selected  = null;
            if ($id != null) {
                $list = Json::decode($refcomponent->getSampletype($id),true);
                if(count($list) > 0){
                    //$selected = '';
                    foreach ($list as $i => $sampletype) {
                        $out[] = ['id' => $sampletype['sampletype_id'], 'name' => $sampletype['type']];
                        //if ($i == 0) {
                            //$selected = $sampletype['sampletype_id'];
                        //}
                    }
                    // Shows how you can preselect a value
                    //echo Json::encode(['output' => $out, 'selected'=>$selected]);
                    \Yii::$app->response->data = Json::encode(['output'=>$out]);
                    return;
                }
            }
        }
        //echo Json::encode(['output' => '', 'selected'=>'']);
        echo Json::encode(['output'=>'']);
    }

    public function actionList_testname() {
        $refcomponent = new ReferralComponent();
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $lab_id = (int) ($_POST['depdrop_parents'][0]);
            $sampletype_id = (int) ($_POST['depdrop_parents'][1]);
            //$selected  = null;
            if ($lab_id > 0 && $sampletype_id > 0) {
                $list = Json::decode($refcomponent->getTestnames($lab_id,$sampletype_id),true);
                if(count($list) > 0){
                    //$selected = '';
                    foreach ($list as $i => $testname) {
                        $out[] = ['id' => $testname['testname_id'], 'name' => $testname['test_name']];
                        //if ($i == 0) {
                        //    $selected = $testname['testname_id'];
                        //}
                    }
                    // Shows how you can preselect a value
                    //echo Json::encode(['output' => $out, 'selected'=>$selected]);
                    \Yii::$app->response->data = Json::encode(['output'=>$out]);
                    return;
                }
            }
        }
        //echo Json::encode(['output' => '', 'selected'=>'']);
        echo Json::encode(['output'=>'']);
    }

    //get referral method reference
    protected function listReferralmethodref($labId,$sampletypeId,$testnameId)
    {
        if(isset($testnameId) && isset($sampletypeId) && isset($labId))
        {
            if($testnameId > 0 && $sampletypeId > 0 && $labId > 0){
                $refcomponent = new ReferralComponent();
                $data = $refcomponent->getMethodrefs($labId,$sampletypeId,$testnameId);
            } else {
                $data = [];
            }

        } else {
            $data =[];
        }
        return $data;
    }

    public function actionGettestnamemethod()
    {
        set_time_limit(120);
        $testnameId = (int) Yii::$app->request->get('testname_id');
        $sampletypeId = (int) Yii::$app->request->get('sampletype_id');
        $labId = (int) Yii::$app->request->get('lab_id');
        if ($testnameId > 0 && $sampletypeId > 0 && $labId > 0){
            $methods = json_decode($this->listReferralmethodref($labId,$sampletypeId,$testnameId),true);
        }
        else {
            $methods = [];
        }

        if (Yii::$app->request->isAjax) {
            $methodrefDataProvider = new ArrayDataProvider([
                //'key'=>'sample_id',
                'allModels' => $methods,
                'pagination' => [
                    'pageSize' => 10,
                ],
                //'pagination'=>false,
            ]);
            return $this->renderAjax('_methodreference', [
                'methodrefDataProvider' => $methodrefDataProvider,
                //'model' => $model,
                'count_methods' => count($methods),
            ]);
        }
    }
}
