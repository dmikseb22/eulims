<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\LabNotebook;
use common\models\lab\LabNotebookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\Exception;
/**
 * NotebookController implements the CRUD actions for LabNotebook model.
 */
class NotebookController extends Controller
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
     * Lists all LabNotebook models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LabNotebookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LabNotebook model.
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
     * Creates a new LabNotebook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LabNotebook();

        if ($model->load(Yii::$app->request->post())) {
            $thefile = UploadedFile::getInstance($model, 'file');
            if (!empty($thefile) && $thefile !== 0) {                
                $thefile->saveAs('uploads/notebooks/' . $model->notebook_name.date("Y-m-d").'.'.$thefile->extension);
                $model->file =$model->notebook_name.date("Y-m-d").'.'.$thefile->extension;
            }
            $model->date_created=date("Y-m-d");
            $model->created_by=Yii::$app->user->identity->profile->user_id;
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Notebook Successfully Added!');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LabNotebook model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->notebook_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDownload($id){
        $download = LabNotebook::findOne($id);
        // $i = '/\uploads/\notebooks/\';
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/notebooks/'.$download->file;

        if (file_exists($path)) {
            //return \Yii::$app->response->sendFile($download->pre_paper,@file_get_contents($path));
            return Yii::$app->response->sendFile($path);
        }else{
            echo "PATH not found!" ;
            
        }
    }

    /**
     * Deletes an existing LabNotebook model.
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
     * Finds the LabNotebook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LabNotebook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LabNotebook::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
