<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Cancelledrequest;
use common\models\lab\CancelledrequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Request;
use common\models\finance\Paymentitem;
use common\models\lab\Sample;
use common\components\Functions;
use common\models\system\Profile;
/**
 * CancelrequestController implements the CRUD actions for Cancelledrequest model.
 */
class CancelrequestController extends Controller
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
        $searchModel = new CancelledrequestSearch();
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
    /*
    Created By: Bergel T. Cutara
    Contacts:

    Email: b.cutara@gmail.com
    Tel. Phone: (062) 991-1024
    Mobile Phone: (639) 956200353

    Description: CAncels the Request (cancel status = 0, if the request has payment items or receipt then the request cannot be cancelled.

     * Creates a new Cancelledrequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $get= \Yii::$app->request->get();
        $model = new Cancelledrequest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $Request= Request::find()->where(['request_id'=>$model->request_id])->one();
            $Request->status_id=0;//Cancelled
            if($Request->save(false))
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]); 

            return $this->redirect(['/lab/request/',]); 
           
        } else {

            $Request_id=$get['req'];
            //Gets the details of the Request
            $request=  Request::find()->where(['request_id'=>$Request_id])->one();
            $model->cancel_date=date('Y-m-d H:i:s');
            $model->request_ref_num=$request->request_ref_num;
            $model->request_id=$request->request_id;
            $model->cancelledby= Yii::$app->user->id;

            // Query Profile Name
            $Profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
            $UserCancel=$Profile->fullname;

            //Gets to know if the Request already have the payment items
            $HasOP= Paymentitem::find()->where(['request_id'=>$Request_id])->count();

            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                    'Req_id'=> $Request_id,
                    'HasOP'=>$HasOP,
                    'request'=>$request,
                    'UserCancel'=>$UserCancel
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'Req_id'=> $Request_id,
                    'HasOP'=>$HasOP,
                    'request'=>$request,
                    'UserCancel'=>$UserCancel
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
