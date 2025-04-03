<?php

namespace frontend\modules\finance\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\finance\CancelledOp;
use common\models\finance\CancelledopSearch;
use common\models\finance\Op;
use yii\db\Query;
/**
 * CancelrequestController implements the CRUD actions for Cancelledrequest model.
 */
class CancelopController extends Controller
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
     * Lists all Cancelledrequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CancelledopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cancelledrequest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cancelledrequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $get= \Yii::$app->request->get();
        $model = new CancelledOp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Update Request
            $op_id=$model->orderofpayment_id;
            
            $op= Op::find()->where(['orderofpayment_id'=>$op_id])->one();
            $op->payment_status_id=0;
            $connection= Yii::$app->financedb;
            $sql_query = $connection->createCommand('UPDATE tbl_paymentitem set status=0 WHERE orderofpayment_id=:op_id');
            $sql_query->bindParam(':op_id',$op_id);
            $sql_query->execute();
                
            $lists=(new Query)
            ->select(['GROUP_CONCAT(`tbl_paymentitem`.`request_id`) as `ids`'])
            ->from('`eulims_finance`.`tbl_paymentitem`')
             ->where(['orderofpayment_id' => $model->orderofpayment_id])
            ->one();

            if($lists['ids']){
                $connection1= Yii::$app->labdb;
                $sql_query1 = $connection1->createCommand('UPDATE tbl_request set posted=0,payment_status_id=1 WHERE request_id IN('.$lists['ids'].')');
                $sql_query1->execute();
            }
                
            $op->save(false);
            return $this->redirect(['/finance/op/view', 'id' => $model->orderofpayment_id]);
        } else {
            $orderofpayment_id=$get['op'];
            $model->cancel_date=date('Y-m-d H:i:s');
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                    'op_id'=> $orderofpayment_id
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'op_id'=> $orderofpayment_id
                ]);
            }
        }
    }

    /**
     * Updates an existing Cancelledrequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->canceledrequest_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cancelledrequest model.
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
     * Finds the Cancelledrequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cancelledrequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cancelledrequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
