<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Orseries;
use common\models\finance\OrseriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrseriesController implements the CRUD actions for Orseries model.
 */
class OrseriesController extends Controller
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
     * Lists all Orseries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrseriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orseries model.
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
     * Creates a new Orseries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orseries();

        if ($model->load(Yii::$app->request->post())) {
            $rstl_id=Yii::$app->user->identity->profile->rstl_id;
            $model->rstl_id=$rstl_id;
            $model->terminal_id=0;
            $model->save();
            //return $this->redirect(['view', 'id' => $model->or_series_id]);
             Yii::$app->session->setFlash('success', 'O.R Series,Successfully added!');
            return $this->redirect(['/finance/orseries']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orseries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'O.R Series,Successfully updated!');
            return $this->redirect(['/finance/orseries']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orseries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
         Yii::$app->session->setFlash('success', 'O.R Series,Successfully deleted!');
         return $this->redirect(['/finance/orseries']);
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Orseries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orseries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orseries::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
