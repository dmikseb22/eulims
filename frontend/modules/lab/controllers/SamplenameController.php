<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\SampleName;
use common\models\lab\SampleNameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SamplenameController implements the CRUD actions for SampleName model.
 */
class SamplenameController extends Controller
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
     * Lists all SampleName models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SampleNameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SampleName model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        /* return $this->render('view', [
            'model' => $this->findModel($id),
        ]); */
		if (Yii::$app->request->isAjax) {
			return $this->renderAjax('_view', [
				'model' => $this->findModel($id),
			]);
        } else {
            return $this->render('view', [
				'model' => $this->findModel($id),
			]);
        }
    }

    /**
     * Creates a new SampleName model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SampleName();

        /* if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sample_name_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]); */
		if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				Yii::$app->session->setFlash('success', $model->sample_name." Successfully Created.");
                return $this->redirect('/lab/samplename');

            }
		} elseif (Yii::$app->request->isAjax) {
			return $this->renderAjax('_form', [
				'model' => $model,
			]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SampleName model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				Yii::$app->session->setFlash('success', $model->sample_name." Successfully Updated.");
                return $this->redirect('/lab/samplename');

            }
		} elseif (Yii::$app->request->isAjax) {
			return $this->renderAjax('_form', [
				'model' => $model,
			]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SampleName model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
		
		if($this->findModel($id)->delete()){
			Yii::$app->session->setFlash('warning', 'Successfully Deleted.');
			return $this->redirect(['index']);
		} else {
			Yii::$app->session->setFlash('error', 'Delete not successful.');
		}
    }

    /**
     * Finds the SampleName model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SampleName the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SampleName::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
