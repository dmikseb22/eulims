<?php

namespace frontend\modules\services\controllers;

use Yii;
use common\models\services\Workflow;
use common\models\services\WorkflowSearch;
use common\models\services\Procedure;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkflowController implements the CRUD actions for Workflow model.
 */
class WorkflowController extends Controller
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
     * Lists all Workflow models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkflowSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Workflow model.
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
     * Creates a new Workflow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($test_id)
    {
        $model = new Workflow();
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $session = Yii::$app->session;
                $session->set('savepopup',"executed");
                return $this->redirect('/services/test/index'); 
        }

        //get the steps of procedures here
        $items = [];
        $products = Procedure::find()->all();
        foreach ($products as $p) {
            $items[$p->procedure_id] = [
                'content' => $p->procedure_name,
                'options' => ['data' => ['id'=>$p->procedure_id]],
            ];
        }

        // $model->rstl_id = $GLOBALS['rstl_id'];
        // $model->pstcanalysis_id = $GLOBALS['rstl_id'];
       if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                    'model' => $model,
                    'test_id'=>$test_id,
                    'items'=>$items
                ]);
        }
        else{
            return $this->render('create', [
                    'model' => $model,
                    'test_id'=>$test_id,
                    'items'=>$items
                ]);

        }
    }

    /**
     * Updates an existing Workflow model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->workflow_id]);
        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Workflow model.
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
     * Finds the Workflow model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Workflow the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Workflow::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
