<?php

namespace backend\modules\system\controllers;

use Yii;
use common\models\lab\Lab;
use common\models\lab\RstlLab;
use common\models\lab\LabSearch;
use common\models\lab\LabManagerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LabController implements the CRUD actions for Lab model.
 */
class ConfigurationsController extends Controller
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
     * Lists all Lab models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LabSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Lab model.
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
     * Creates a new Lab model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lab();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Laboratory Successfully Saved!');
            \Yii::$app->session['config-item']=1;
            return $this->redirect(['/system/configurations']);
        } else {
            $model->labcount=0;
            $model->active=0;
            $model->nextrequestcode='';
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Lab model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->labcode= strtoupper($model->labcode);
            if ($model->save()){
                Yii::$app->session->setFlash('success', 'Laboratory Successfully Updated!');
                \Yii::$app->session['config-item']=1;

                $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

                $rstllab = new RstlLab();
                $rstllab->rstl_id = $GLOBALS['rstl_id'];
                $rstllab->lab_id= $id;
                $rstllab->created_at = 1535437311;
                $rstllab->lab_color = 1;
                $rstllab->save(false);

                return $this->redirect(['/system/configurations']);
            }else{
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
            
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }   
        if(Yii::$app->request->isAjax){
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Lab model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Lab model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lab the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lab::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
