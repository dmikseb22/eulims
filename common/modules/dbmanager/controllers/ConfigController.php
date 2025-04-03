<?php

namespace common\modules\dbmanager\controllers;

use Yii;
use common\models\system\BackupConfig;
use common\models\system\BackupConfigSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfigController implements the CRUD actions for BackupConfig model.
 */
class ConfigController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all BackupConfig models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BackupConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BackupConfig model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new BackupConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BackupConfig();
        //Truncate the config table
        $this->TruncateTConfig();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Configuration Created Successfully!');
            return $this->redirect('/dbmanager/config/');
        } else {
            if(Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing BackupConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Configuration Updated Successfully!');
            return $this->redirect('/dbmanager/config/');
        } else {
            if(Yii::$app->request->isAjax){
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Truncates an existing BackupConfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->TruncateTConfig();
        return $this->redirect(['index']);
    }
    /**
     * Function to truncate backup config table
     */
    protected function TruncateTConfig(){
        $Connection=Yii::$app->db;
        $Command=$Connection->createCommand("TRUNCATE `tbl_backup_config`;");
        if($Command->execute()){
            Yii::$app->session->setFlash('success', 'Configuration Truncated Successfully!');
        }else{
            Yii::$app->session->setFlash('danger', 'Configuration Failed to Truncate!'); 
        }
    }
    /**
     * Finds the BackupConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BackupConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BackupConfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
