<?php

namespace frontend\modules\inventory\controllers;

use Yii;
use common\models\inventory\InventoryEntries;
use common\models\inventory\InventoryEntriesSearch;
use common\models\inventory\Products;
use common\models\inventory\Suppliers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;


/**
 * InventoryentriesController implements the CRUD actions for InventoryEntries model.
 */
class InventoryentriesController extends Controller
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
     * Lists all InventoryEntries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new InventoryEntries();
        $searchModel = new InventoryEntriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model'=>$model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InventoryEntries model.
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
     * Creates a new InventoryEntries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InventoryEntries();
        $model->rstl_id=Yii::$app->user->identity->profile->rstl_id;
        $user_id=Yii::$app->user->identity->profile->user_id;
        $model->created_by=$user_id;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->inventorydb->beginTransaction();
            $session = Yii::$app->session; 
            try  {
                $total= $model->quantity * $model->amount;
                $model->total_amount=$total;
                $model->quantity_onhand = $model->quantity;
                if ($model->save()){
                    $qty=$model->product->qty_onhand;
                    $total_qty=$qty + $model->quantity;
                    $this->updateQtyProduct($model->product_id,$total_qty);
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Product Entry Created!');
                    return $this->redirect(['/inventory/inventoryentries']);
                    // return $this->redirect(['view', 'id' => $model->inventory_transactions_id]); 
                }
                
                
            } catch (Exception $e) {
                $transaction->rollBack();
               Yii::$app->session->setFlash('warning', 'Transaction Error!');
                return $this->redirect(['/inventory/inventoryentries']);
             }
           
        }
        
        
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                    'model' => $model,
                ]);
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InventoryEntries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->inventory_transactions_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing InventoryEntries model.
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
     * Finds the InventoryEntries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InventoryEntries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryEntries::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionProductlist($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('product_id as id, product_name AS text')
                    ->from('tbl_products')
                    ->where(['like', 'product_name', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $command->db= \Yii::$app->inventorydb;
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' =>Products::find()->where(['product_id'=>$id])->product_name];
        }
        return $out;
    }

    public function actionSupplierlist($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('suppliers_id as id, suppliers AS text')
                    ->from('tbl_suppliers')
                    ->where(['like', 'suppliers', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $command->db= \Yii::$app->inventorydb;
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' =>Suppliers::find()->where(['suppliers_id'=>$id])->suppliers];
        }
        return $out;
    }
    public function actionWithdraw($varsearch=""){
        // $product=Products::find()->limit(20)->all();
        $dataProvider = new ActiveDataProvider([
            'query' =>Products::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if($varsearch){
              // $inventory=InventoryEntries::find('product')->where('like','product_name',$_GET['varsearch']);
              
              // var_dump($product); exit;
        }

          return $this->render('withdraw',['dataProvider'=>$dataProvider,'searchkey'=>$varsearch]);
    }

    public function actionIncart(){
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('withdraw', [
                
            ]);
        }
        else {
            return $this->render('withdraw', [
               
            ]);
        }
    }
    
    public function updateQtyProduct($id,$qty) {
        Yii::$app->inventorydb->createCommand()
        ->update('tbl_products', ['qty_onhand' => $qty], 'product_id= '.$id)
        ->execute(); 
    }
}
