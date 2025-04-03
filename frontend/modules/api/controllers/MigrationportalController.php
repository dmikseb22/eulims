<?php

namespace frontend\modules\api\controllers;

use Yii;
use common\models\api\Migrationportal;
use common\models\api\MigrationportalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Customer;
use common\models\lab\CustomerMigration;
use common\models\api\CustomerMigrationportal;

use common\models\lab\RequestMigration;

use common\models\lab\Jobportal;
use yii\data\ActiveDataProvider;


/**
 * MigrationportalController implements the CRUD actions for Migrationportal model.
 */
class MigrationportalController extends Controller
{

    private $batchlimit=100;
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
     * Lists all Migrationportal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MigrationportalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $fetchlings = Migrationportal::find()->all();
        
        // $jobs = Jobportal::find()->where(['rstl_id'=>Yii::$app->user->identity->profile->rstl_id]);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $jobs,
        // ]);


        $alllrequest= RequestMigration::find()->count();
        $migrequest= RequestMigration::find()->where(['is_migrated'=>1])->count();
        $rawrequest= RequestMigration::find()->where(['is_migrated'=>0])->count();

        return $this->render('index', [
            // 'dataProvider' => $dataProvider,
            'allreq'=>$alllrequest,
            'migreq'=>$migrequest,
            'rawreq'=>$rawrequest,
        ]);
    }

    /**
     * Displays a single Migrationportal model.
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
     * Creates a new Migrationportal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Migrationportal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pm_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Migrationportal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pm_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Migrationportal model.
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
     * Finds the Migrationportal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Migrationportal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Migrationportal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFetch_customer($start){
        // initiations
        $connection= Yii::$app->labdb;

        //fetch the the record by 1000
        $fetch = CustomerMigration::find()->orderBy(["customer_id"=>SORT_ASC])->limit($this->batchlimit)->offset($start)->all();

        if($fetch){
            $transaction = $connection->beginTransaction();
            try {
                $ctr = 0;
                foreach ($fetch as $fi) {
                //use transaction here
                    $newcustomer = new CustomerMigrationportal();
                    $newcustomer->attributes = $fi->attributes;
                    if($newcustomer->save()){
                        $ctr++;
                    }else{
                        goto sadbear;
                        break;
                    }
                }
                    //if the compiler reach this area it just mean that all the record has been save and that the system will now update the tbl_migrationportal
                    $transaction->commit();

                    $fetchling = Migrationportal::find()->where(['table_name'=>'customer'])->one();
                    $fetchling->date_migrated= date("Y-m-d");
                    $fetchling->record_id=$start+$ctr;
                    $fetchling->save(false);
                    Yii::$app->session->setFlash('success', "Fetched ".$ctr." customer records");
                
            } catch (Exception $e) {
                sadbear:
                $transaction->rollback();
            }
        }
        else{
            Yii::$app->session->setFlash('error', "No new customer record/s found");
        }
        

        return $this->redirect(['index']);
    }

    public function actionScript_customer($start){
        // initiations
        $connection= Yii::$app->labdb;

        //fetch the the record by 1000
        $fetch = CustomerMigrationPortal::find()->orderBy(["customer_id"=>SORT_ASC])->limit($this->batchlimit)->offset($start)->all();
        if($fetch){
            $transaction = $connection->beginTransaction();
            try {
                $ctr = 0;
                $connection->createCommand('set foreign_key_checks=0')->execute();
                foreach ($fetch as $fi) {
                
                    $fi->customer_code =  $fi->rstl_id."-".$fi->customer_old_id;
                    if($fi->save(false)){
                        $newrecord = new Customer();
                        $newrecord->attributes = $fi->attributes;
                        if($newrecord->save(false))
                            $ctr++;
                        else{
                             goto sadbear;
                             break;
                        }
                        
                        
                    }else{
                        goto sadbear;
                        break;
                    }
                }
                $connection->createCommand('set foreign_key_checks=1')->execute();

                //if the compiler reach this area it just mean that all the record has been save and that the system will now update the tbl_migrationportal
                $transaction->commit();

                $fetchling = Migrationportal::find()->where(['table_name'=>'customer'])->one();
                $fetchling->date_migrated= date("Y-m-d");
                $fetchling->record_idscript=$start+$ctr;
                $fetchling->save(false);
                Yii::$app->session->setFlash('success', "Processed ".$ctr." customer records");
                
            } catch (Exception $e) {
                sadbear:
                $transaction->rollback();
            }
        }
        else{
            Yii::$app->session->setFlash('error', "No new customer record/s to run the script");
        }
         return $this->redirect(['index']);
    }
}
