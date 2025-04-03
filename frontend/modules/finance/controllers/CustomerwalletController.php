<?php

namespace frontend\modules\finance\controllers;

use common\models\finance\Customertransaction;
use common\models\finance\CustomertransactionSearch;
use Yii;
use common\models\finance\Customerwallet;
use common\models\finance\CustomerwalletSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Functions;


/**
 * CustomerwalletController implements the CRUD actions for Customerwallet model.
 */
class CustomerwalletController extends Controller
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
     * Lists all Customerwallet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerwalletSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $Function=new Functions();
        // $Params=['mCustomerID'=>2];
        // $Proc="spGetWalletDetails(:mCustomerID)";
        // $Rows=$Function->ExecuteStoredProcedure($Proc, $Params, \Yii::$app->financedb);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customerwallet model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        // $query = Customertransaction::find($id)->all();

        // // add conditions that should always apply here

        // $transactions = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

        $searchModel = new CustomertransactionSearch();
        $transactions = $searchModel->searchbycustomerid($id);


        if(Yii::$app->request->isAjax){

             return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'transactions'=>$transactions
        ]);

        }else{  
           return $this->render('view', [
                'model' => $this->findModel($id),
                'transactions'=>$transactions
            ]);
        }
    }

    /**
     * Creates a new Customerwallet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customerwallet();
        
        if ($model->load(Yii::$app->request->post())) {
            // $model->last_update=date('Y-m-d h:i:s');
            // $model->date=date('Y-m-d h:i:s');
            if($model->save() ){
                $session = Yii::$app->session;
                 $wallet = new Customertransaction();
                 $wallet->updated_by =Yii::$app->user->id;
                 $wallet->date =date('Y-m-d h:i:s');
                 $wallet->transactiontype =2;
                 $wallet->amount =$model->balance;
                 $wallet->balance=$model->balance;
                 $wallet->customerwallet_id=$model->customerwallet_id;
                 $wallet->save();
                 $session->set('savepopup',"executed");
                 return $this->redirect('index');
            }
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                    'model' => $model,
                ]);
        }
        else{
             return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing Customerwallet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->customerwallet_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customerwallet model.
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
     * Finds the Customerwallet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customerwallet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customerwallet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
