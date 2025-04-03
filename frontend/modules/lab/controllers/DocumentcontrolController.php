<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Documentcontrol;
use common\models\lab\Documentcontrolconfig;
use common\models\lab\Documentcontrolindex;
use common\models\lab\DocumentcontrolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\models\lab\Labsampletype;
use common\models\lab\Sampletype;
use common\models\lab\LabsampletypeSearch;
use common\models\system\Profile;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\lab\SampleSearch;

/**
 * DocumentcontrolController implements the CRUD actions for Documentcontrol model.
 */
class DocumentcontrolController extends Controller
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
     * Lists all Documentcontrol models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentcontrolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Documentcontrol model.
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

    /**
     * Creates a new Documentcontrol model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {           
        $model = new Documentcontrol();
        
        $post= Yii::$app->request->post();

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                
                    $documentcontrolconfig = Documentcontrolconfig::find()->where(['documentcontrolconfig_id' => 1])->one();   

                    $dcf = $documentcontrolconfig->dcf;
                    $id = 1;
                    $newdcf = $dcf + 1;

                    $Connection= Yii::$app->labdb;
                    $sql="UPDATE `tbl_documentcontrolconfig` SET `dcf_no`='$newdcf' WHERE `documentcontrolconfig_id`=".$id;
                    $Command=$Connection->createCommand($sql);
                    $Command->execute();
      
                    $documentcontrolindex = new Documentcontrolindex();
                    $documentcontrolindex->dcf_no = $post['Documentcontrol']['dcf_no'];
                    $documentcontrolindex->document_code = $post['Documentcontrol']['code_num'];
                    $documentcontrolindex->title = $post['Documentcontrol']['title'];
                    $documentcontrolindex->rev_no = $post['Documentcontrol']['new_revision_no'];
                    $documentcontrolindex->effectivity_date = $post['Documentcontrol']['effective_date'];
                    $documentcontrolindex->dc = $post['Documentcontrol']['dcf_no'];
                    $documentcontrolindex->save(false);
             
                    Yii::$app->session->setFlash('success', 'Document Control Form Successfully Created'); 
                    return $this->runAction('index');
                }
                    $documentcontrolconfig = Documentcontrolconfig::find()->where(['documentcontrolconfig_id' => 1])->one();    

                    $approved = $documentcontrolconfig->approved;
                    $custodian = $documentcontrolconfig->custodian;
                    $dcf = $documentcontrolconfig->dcf + 1;
                    $year = $documentcontrolconfig->year;    
                    $model->approved_by = $approved;
                    $model->reviewed_by = $custodian;
                    $model->custodian = $custodian;

                    $len = strlen ($dcf);
                    if ($len==1){
                        $model->dcf_no = "00".$dcf."-".$year;
                    }elseif ($len==2){
                        $model->dcf_no = "0".$dcf."-".$year;
                    }else{
                        $model->dcf_no = $dcf."-".$year;
                    }

                    return $this->renderAjax('_form', [
                        'model' => $model,
                    ]);
    }

    /**
     * Updates an existing Documentcontrol model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

     public function actionGettitle() {
        if(isset($_GET['code_num'])){
            $id = $_GET['code_num'];

            $modeldoc =  Documentcontrol::findOne(['code_num'=>$_GET['code_num']]);
            $title = $modeldoc->title;
        } else {
            $title = "Error getting unit cost";
         }
        return Json::encode([
            'title'=>$title,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Document Control Form Successfully Updated'); 
                    return $this->redirect(['index']);

                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('update', [
                        'model' => $model,
                    ]);
                 }
    }

    /**
     * Deletes an existing Documentcontrol model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
        if($model->delete()) {            
            Yii::$app->session->setFlash('success', 'Document Control Form Successfully Deleted'); 
            return $this->redirect(['index']);
        } else {
            return $model->error();
        }
    }

    /**
     * Finds the Documentcontrol model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Documentcontrol the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Documentcontrol::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
