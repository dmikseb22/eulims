<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Customerwallet;
use common\models\finance\CustomerwalletSearch;
use common\models\finance\Customertransaction;
use common\models\finance\CustomertransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomertransactionController implements the CRUD actions for Customertransaction model.
 */
class CustomertransactionController extends Controller
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
     * Lists all Customertransaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new CustomertransactionSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);

        $searchwallet = new CustomerWalletSearch();
        $walletdataProvider = $searchwallet->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchwallet' => $searchwallet,
            'walletdataProvider' => $walletdataProvider,
        ]);
    }

    /**
     * Displays a single Customertransaction model.
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
     * Creates a new Customertransaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($customerwallet_id)
    {

        $model = new Customertransaction();

         if ($model->load(Yii::$app->request->post())) {
            $model->date= date('Y-m-d h:i:s');
            //0 = credit ,1 = debit
            $model->transactiontype=0;
            $model->updated_by=Yii::$app->user->id;
            // if($model->save(false)){
                $wallet = Customerwallet::find()->where(['customerwallet_id' => $model->customerwallet_id])->one();
                $wallet->balance = $wallet->balance + $model->amount;
                // $wallet->last_update=date('Y-m-d  h:i:s');
                if($wallet->save()){
                    $session = Yii::$app->session;
                    $model->balance= $wallet->balance;
                    $model->save();
                    $session->set('savepopup',"executed");
                    return $this->redirect(['/finance/customerwallet']);
                }
            // }

        }
        
        if(Yii::$app->request->isAjax){
             
            return $this->renderAjax('create', [
                'model' => $model,
                'customerwallet_id'=>$customerwallet_id
            ]);
                
        }else{  
           
            return $this->render('create', [
                'model' => $model,
                'customerwallet_id'=>$customerwallet_id
            ]);
        }
    }

    /**
     * Updates an existing Customertransaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->customertransaction_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customertransaction model.
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
     * Finds the Customertransaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customertransaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customertransaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
