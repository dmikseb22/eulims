<?php

namespace backend\modules\system\controllers;

use Yii;
use common\models\lab\LabManager;
use common\models\lab\LabManagerSearch;
use common\models\system\Labrbac;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LabmanagerController implements the CRUD actions for LabManager model.
 */
class LabmanagerController extends Controller
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
     * Lists all LabManager models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LabManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LabManager model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model= Labrbac::find()->where(['user_id'=>$id])->one();
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $model,
            ]);
        }else{
            return $this->render('view', [
                
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new LabManager model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LabManager();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('success', 'Technical Manager Successfully Added!');
            \Yii::$app->session['config-item']=2;
            return $this->redirect('/system/configurations');
        }
        $model->updated_at=date("U");
        $model->rstl_id=Yii::$app->user->identity->profile->rstl_id;
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

    /**
     * Updates an existing LabManager model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //$model = LabManager::find()->where(['user_id'=>$id])->one();
        $model = LabManager::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Technical Manager Successfully Updated!');
            \Yii::$app->session['config-item']=2;
            return $this->redirect('/system/configurations');
        }
        if(\Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }else{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LabManager model.
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
     * Finds the LabManager model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LabManager the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LabManager::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
