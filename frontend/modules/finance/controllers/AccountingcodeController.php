<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Accountingcode;
use common\models\finance\AccountingcodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * AccountingcodeController implements the CRUD actions for Accountingcode model.
 */
class AccountingcodeController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all Accountingcode models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AccountingcodeSearch();
        $dataProvider2 = $searchModel->search(Yii::$app->request->queryParams);
        
       
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM eulims_finance.tbl_accountingcode ac
            LEFT JOIN eulims_finance.tbl_accountingcodemapping acm ON ac.`accountingcode_id`=acm.`accountingcode_id`
            LEFT JOIN eulims_finance.tbl_collectiontype ct ON acm.`collectiontype_id` = ct.`collectiontype_id`
            ORDER BY ac.accountingcode_id ')->queryScalar();
        $queryNew = new yii\db\Query;


                              $queryNew->select('eulims_finance.tbl_accountingcode.accountcode, eulims_finance.tbl_collectiontype.natureofcollection')
                              ->from('eulims_finance.tbl_accountingcode')
                              ->leftJoin('eulims_finance.tbl_accountingcodemapping', 'eulims_finance.tbl_accountingcode.accountingcode_id = eulims_finance.tbl_accountingcodemapping.accountingcode_id')    
                              ->leftJoin('eulims_finance.tbl_collectiontype', 'eulims_finance.tbl_accountingcodemapping.collectiontype_id = eulims_finance.tbl_collectiontype.collectiontype_id')
                              ->orderBy('eulims_finance.tbl_accountingcode.accountingcode_id DESC');
                                
                               $dataProvider= new ActiveDataProvider([
                                  'query' => $queryNew,
                                   'totalCount' => $count,
                               'pagination' => [
                                      'pageSize' => 6
                                  ],

                              ]);



        return $this->render('index', [
                //   'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Accountingcode model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (Yii::$app->request->isAjax)
        {
           return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
        ]); 
        }
        else
        {
           return $this->render('view', [
                    'model' => $this->findModel($id),
        ]); 
        }
        
    }

    /**
     * Creates a new Accountingcode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Accountingcode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // return $this->redirect(['view', 'id' => $model->accountingcode_id]);
              $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM eulims_finance.tbl_accountingcode ac
            LEFT JOIN eulims_finance.tbl_accountingcodemapping acm ON ac.`accountingcode_id`=acm.`accountingcode_id`
            LEFT JOIN eulims_finance.tbl_collectiontype ct ON acm.`collectiontype_id` = ct.`collectiontype_id`
            ORDER BY ac.accountingcode_id ')->queryScalar();
        $queryNew = new yii\db\Query;


                              $queryNew->select('eulims_finance.tbl_accountingcode.accountcode, eulims_finance.tbl_collectiontype.natureofcollection')
                              ->from('eulims_finance.tbl_accountingcode')
                              ->leftJoin('eulims_finance.tbl_accountingcodemapping', 'eulims_finance.tbl_accountingcode.accountingcode_id = eulims_finance.tbl_accountingcodemapping.accountingcode_id')    
                              ->leftJoin('eulims_finance.tbl_collectiontype', 'eulims_finance.tbl_accountingcodemapping.collectiontype_id = eulims_finance.tbl_collectiontype.collectiontype_id')
                              ->orderBy('eulims_finance.tbl_accountingcode.accountingcode_id DESC');
                                
                               $dataProvider= new ActiveDataProvider([
                                  'query' => $queryNew,
                                   'totalCount' => $count,
                               'pagination' => [
                                      'pageSize' => 6
                                  ],

                              ]);



        return $this->runAction('index', [
                //   'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                        'model' => $model,
            ]);
        } else {

            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Accountingcode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->accountingcode_id]);
        }
        
        
         if (Yii::$app->request->isAjax)
         {
         return $this->renderAjax('update', [
                        'model' => $model,
            ]);
         }
         else
         {
            return $this->render('update', [
                        'model' => $model,
            ]);
         }
    }

    /**
     * Deletes an existing Accountingcode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    
    public function actionMapping() {
        if (Yii::$app->request->isAjax)
        {
           return $this->renderAjax('mapping'); 
        }
        else
        {
           return $this->render('mapping'); 
       
        }
        
    }

    /**
     * Finds the Accountingcode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accountingcode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Accountingcode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    

}
