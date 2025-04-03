<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Procedure;
use common\models\lab\ProcedureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProcedureController implements the CRUD actions for Procedure model.
 */
class ProcedureController extends Controller
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
     * Lists all Procedure models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcedureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Procedure model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
			return $this->renderAjax('view', [
				'model' => $this->findModel($id),
			]);
        } else {
            return $this->render('view', [
				'model' => $this->findModel($id),
			]);
        }
    }

    public function actionWorkflow($id)
    {
    
        if(Yii::$app->request->isAjax){
        return $this->renderAjax('_workflow', [
        ]);
        }
    }

    /**
     * Creates a new Procedure model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Procedure();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // $model->procedure_code=1;
            $model->testname_id=2;
            $model->testname_method_id=3;
            Yii::$app->session->setFlash('success', 'Procedure Successfully Created'); 
            return $this->runAction('index');
        } 
            //$model->procedure_code=1;
            $model->testname_id=2;
            $model->testname_method_id=3;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
       }
     
    }

    /**
     * Updates an existing Procedure model.
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
				Yii::$app->session->setFlash('success', $model->procedure_name." Successfully Updated.");
                return $this->runAction('index');
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
     * Deletes an existing Procedure model.
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
     * Finds the Procedure model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Procedure the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Procedure::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
