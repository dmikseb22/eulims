<?php

namespace frontend\modules\lab\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Testname;
use common\models\system\RstlDetails;
use common\models\system\Profile;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use common\models\system\User;
use common\models\system\UserSearch;

use common\models\lab\TestnameSearch;

use common\models\lab\Lab;
use common\models\lab\LabSearch;

use common\models\lab\CodeTemplate;
use common\models\lab\RstlLab;
use common\models\lab\Requestcode;
use common\models\lab\Configlab;
use common\models\lab\Samplecode;

/**
 * SetupController implements the CRUD actions for Setup model.
 */
class SetupController extends Controller
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
     * Lists all Sampletypetestname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $rstl=Yii::$app->user->identity->profile->rstl_id;

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $labsearchModel = new LabSearch();
        $labdataProvider = $labsearchModel->search(Yii::$app->request->queryParams);

        $codetemplate = CodeTemplate::find()->where(['generate_mode' => 0]);
        $codetemplatedataprovider = new ActiveDataProvider([
                'query' => $codetemplate,
                'pagination' => [
                    'pageSize' => false,
                           ],                   
        ]);

        
        $rstllab = RstlLab::find()->where(['rstl_id' => $rstl]);
        $rstllabdataprovider = new ActiveDataProvider([
                'query' => $rstllab,
                'pagination' => [
                    'pageSize' => false,
                           ],                   
        ]);

        $requestcode = Requestcode::find()->where(['rstl_id' => $rstl]);
        $requestcodedataprovider = new ActiveDataProvider([
                'query' => $requestcode,
                'pagination' => [
                    'pageSize' => false,
                           ],                   
        ]);

        $configlab = Configlab::find()->where(['configlab_id' => 1]);
        $configlabdataprovider = new ActiveDataProvider([
                'query' => $configlab,
                'pagination' => [
                    'pageSize' => false,
                           ],                   
        ]);
      
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'labdataProvider'=> $labdataProvider,
            'codetemplatedataprovider'=>$codetemplatedataprovider,
            'rstllabdataprovider'=>$rstllabdataprovider,
            'configlabdataprovider'=>$configlabdataprovider,
            'requestcodedataprovider'=>$requestcodedataprovider
        ]);
    }

    /**
     * Displays a single Sampletypetestname model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]);
        }
    }

    public function actionLabdetails()
    {
                //here
                $model = new RstlDetails();
               
                $post= Yii::$app->request->post();
                if ($model->load(Yii::$app->request->post())) {
                            return $this->runAction('index');
                    }      

                if(Yii::$app->request->isAjax){
                    return $this->renderAjax('labdetails', [
                        'model' => $model,
                    ]);
               }
    }

    public function actionUseraccounts()
    {
                $model = new User();
               
                $post= Yii::$app->request->post();
                if ($model->load(Yii::$app->request->post())) {
                            return $this->runAction('index');
                        }      

                if(Yii::$app->request->isAjax){
                    return $this->renderAjax('useraccounts', [
                        'model' => $model,
                    ]);
               }
    }

    public function actionLab()
    {
        $model = new Lab();
               
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
                    return $this->runAction('index');
                }      

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('lab', [
                'model' => $model,
            ]);
       }
    }

    public function actionRequestcodetemplate()
    {
        $model = new Requestcode();
               
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
                    return $this->runAction('index');
                }      

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('requestcodetemplate', [
                'model' => $model,
            ]);
       }
    }

    public function actionConfiglab()
    {
        $model = new Configlab();
               
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
                    return $this->runAction('index');
                }      

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('configlab', [
                'model' => $model,
            ]);
       }
    }

    public function actionRstllab()
    {
        $model = new Rstllab();
               
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
                    return $this->runAction('index');
                }      

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('rstllab', [
                'model' => $model,
            ]);
       }
    }

    public function actionRequestcode()
    {
        $model = new Codetemplate();
               
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
                    return $this->runAction('index');
                }      

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('requestcodetemplate', [
                'model' => $model,
            ]);
       }
    }

    /**
     * Creates a new Sampletypetestname model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sampletypetestname();

        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            $sampletypetestname = Sampletypetestname::find()->where(['sampletype_id'=> $post['Sampletypetestname']['sampletype_id'], 'testname_id'=>$post['Sampletypetestname']['testname_id']])->one();
                 if ($sampletypetestname){
                     Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                      return $this->runAction('index');
                 }else{
                     $model->save();
                     Yii::$app->session->setFlash('success', 'Sample Type Test Name Successfully Created'); 
                     return $this->runAction('index');
                 }      

                }

        $testname = [];
        if(Yii::$app->request->isAjax){
            $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
            if($profile){
              $model->added_by=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
              }else{
                  $model->added_by="";
              }
            return $this->renderAjax('_form', [
                'model' => $model,
                'testname'=>$testname,
            ]);
       }
    }

    /**
     * Updates an existing Sampletypetestname model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
                if ($model->load(Yii::$app->request->post())) {
                    $post= Yii::$app->request->post();
                    $sampletypetestname = Sampletypetestname::find()->where(['sampletype_id'=> $post['Sampletypetestname']['sampletype_id'], 'testname_id'=>$post['Sampletypetestname']['testname_id']])->one();
                    if ($sampletypetestname){
                        Yii::$app->session->setFlash('warning', "The system has detected a duplicate record. You are not allowed to perform this operation."); 
                         return $this->runAction('index');
                    }else{
                        $model->save();
                        Yii::$app->session->setFlash('success', 'Sample Type Test Name Successfully Created'); 
                        return $this->runAction('index');
                    }      
   

                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('update', [
                        'model' => $model,
                    ]);
                 }
    }

    /**
     * Deletes an existing Sampletypetestname model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
        if($model->delete()) {            
            Yii::$app->session->setFlash('success', 'Sample Type Test Name Successfully Deleted'); 
            return $this->redirect(['index']);
        } else {
            return $model->error();
        }
    }

    /**
     * Finds the Sampletypetestname model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sampletypetestname the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sampletypetestname::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function listSampletype()
    {
        $sampletype = ArrayHelper::map(
            Sampletype::find()
            ->leftJoin('tbl_lab_sampletype', 'tbl_sampletype.sampletype_id=tbl_lab_sampletype.sampletype_id')
            ->Where(['tbl_lab_sampletype.lab_id'=>$id])
            ->all(), 'lab_sampletype_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->testName;
        });

        return $sampletype;
    }

    
    public function actionListsampletype() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
          
            $list = Sampletype::find()
            ->leftJoin('tbl_lab_sampletype', 'tbl_sampletype.sampletype_id=tbl_lab_sampletype.sampletype_id')
            ->Where(['tbl_lab_sampletype.lab_id'=>$id])
            ->asArray()
            ->all();

            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $sampletype) {
                    $out[] = ['id' => $sampletype['sampletype_id'], 'name' => $sampletype['type']];
                    if ($i == 0) {
                        $selected = $sampletype['sampletype_id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    public function listTestname()
    {
        $sampletype = ArrayHelper::map(
            Testname::find()
            ->leftJoin('tbl_sampletype_testname', 'tbl_testname.testname_id=tbl_sampletype_testname.testname_id')
            ->Where(['tbl_sampletype_testname.sampletype_id'=>$id])
            ->all(), 'testname_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->testName;
        });

        return $sampletype;
    }

    
    public function actionListtestname() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
          
            $list =  Testname::find()
            ->leftJoin('tbl_sampletype_testname', 'tbl_testname.testname_id=tbl_sampletype_testname.testname_id')
            ->Where(['tbl_sampletype_testname.sampletype_id'=>$id])
            ->asArray()
            ->all();

            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $sampletype) {
                    $out[] = ['id' => $sampletype['testname_id'], 'name' => $sampletype['testName']];
                    if ($i == 0) {
                        $selected = $sampletype['testname_id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }
}
