<?php

namespace frontend\modules\inventory\controllers;

use Yii;
use common\models\inventory\Equipmentservice;
use common\models\inventory\EquipmentserviceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EquipmentserviceController implements the CRUD actions for Equipmentservice model.
 */
class EquipmentserviceController extends Controller
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
     * Lists all Equipmentservice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EquipmentserviceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Equipmentservice model.
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
     * Creates a new Equipmentservice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Equipmentservice();

        if ($model->load(Yii::$app->request->post())) {

            $attachment = UploadedFile::getInstance($model, 'attachment');

            if (!empty($attachment) && $attachment !== 0) {                
                $sds->saveAs('uploads/equipment/' . $model->inventory_transactions_id.$model->equipmentservice_id.'.'.$attachment->extension);
                $model->sds =$model->inventory_transactions_id.$model->equipmentservice_id.'.'.$attachment->extension;
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->equipmentservice_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Equipmentservice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $attachment = UploadedFile::getInstance($model, 'attachment');

            if (!empty($attachment) && $attachment !== 0) {                
                $attachment->saveAs('uploads/equipment/' . $model->inventory_transactions_id.$model->equipmentservice_id.'.'.$attachment->extension);
                $model->attachment =$model->inventory_transactions_id.$model->equipmentservice_id.'.'.$attachment->extension;
            }
            $model->save();
            Yii::$app->session->setFlash('success', 'Schedule Successfully Updated!');
            return $this->redirect(['update', 'id' => $model->equipmentservice_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Equipmentservice model.
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
     * Finds the Equipmentservice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Equipmentservice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Equipmentservice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
