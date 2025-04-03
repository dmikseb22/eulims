<?php

namespace frontend\modules\services\controllers;

use Yii;
use common\models\finance\Op;
use common\models\lab\Request;
use common\models\services\Archive;
use common\models\services\ArchiveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArchiveController implements the CRUD actions for Archive model.
 */
class ArchiveController extends Controller
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

    public function actionIndex()
    {
      
        $searchModel = new ArchiveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionGenerate(){
        
        $post= Yii::$app->request->post();
        $year = $post['year'];
        $year2 = date('Y')-5;
        $migrationCount = Request::find()->leftJoin('tbl_customer','tbl_request.customer_id = tbl_customer.customer_id')->where('year(tbl_request.request_datetime) = '.$year.'')->andWhere(['tbl_request.completed' => NULL])->count(); 
        $migrationTotal = Request::find()->where('year(request_datetime) <= '.$year2)->andWhere(['completed' => NULL])->count();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $response = array(
            "status" => 200,
            "count" => $migrationCount,
            "total" => $migrationTotal,
            "year" => $year
        );
       
        return $response;
    }

    public function actionMigrate()
    {

        
        set_time_limit(0);

        $post= Yii::$app->request->post();
        $year = $post['year']; 
        $requests = Request::find()->leftJoin('tbl_customer','tbl_request.customer_id = tbl_customer.customer_id')->where('year(tbl_request.request_datetime) = '.$year.'')->andWhere(['tbl_request.completed' => NULL])->all(); 

        foreach ($requests as $request)
        {
            $req_no = $request['request_ref_num'];
            $check = Archive::find()->where(['request_no' => $req_no])->one();
            
            if(count($check) > 0){
                $content = []; $samples = []; 
                ($request->customer['customer_name'] == null ) ? $customer = 'Not Available' : $customer = $request->customer['customer_name']; 
                ($request->request_ref_num == null ) ? $ref = 'Not Available' : $ref = $request->request_ref_num;

                foreach ($request->samples as $list) {
                    
                    $analysis = [];
                    foreach($list->analyses as $a){
                        $analysis[] = [
                            'date' => $a['date_analysis'],
                            'name' => $a['testname'],
                            'method' => $a['method'],
                            'references' => $a['references'],
                            'fee' => $a['fee']
                        ];
                    }

                    $samples[] = [  
                        'code' => $list['sample_code'],
                        'name' => $list['samplename'],
                        'description' => $list['description'],
                        'analysis' => $analysis
                    ];
                }

                $op = Op::find()->where(['orderofpayment_id' => $request->payment['orderofpayment_id']])->one();

                $content[] = [
                    'request' => [
                        'id' => $request->request_id,
                        'rstl_id' => $request->rstl_id,
                        'purpose' => $request->purpose['name'],
                        'reference_num' => $request->request_ref_num,
                        'request_datetime' => $request->request_datetime,
                        'labtype' => $request->lab['labname'],
                        'discount' => $request->discount,
                        'total' => $request->total,
                        'conforme' => $request->conforme,
                        'received_by' => $request->receivedBy,
                        'status' => $request->status['status']
                    ],
                    'customer' => [
                        'name' => $request->customer['customer_name'],
                        'address' => $request->customer['address']
                    ],
                    'samples' => $samples,
                    'payment' => [
                        'amount' => $request->payment['amount'],
                        'transaction' => $op['transactionnum'],
                        'invoice' => $op['invoice_number']
                    ]
                ];

                $id = $request->request_id;
                $status = Request::find()->where(['request_id' => $id])->one();
                $status->completed = 'Migrated';
                $status->save(false);

                $new = new Archive;
                $new->customer = $customer;
                $new->request_no = $ref;
                $new->content = json_encode($content);
                $new->status = 'New';
                $new->created_at = date("Y-m-d H:i:s");
                // $new->updated_at = date("Y-m-d H:i:s");
                $new->save();
            
            }else{
                return false;
            }
        }
      
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $migrationCount = Request::find()->leftJoin('tbl_customer','tbl_request.customer_id = tbl_customer.customer_id')->where('year(tbl_request.request_datetime) = '.$year.'')->andWhere(['tbl_request.completed' => NULL])->count(); 
        $migrationTotal = Request::find()->where(['completed' => NULL])->count();

        $response = array(
            "status" => 200,  
            "count" => $migrationCount,
            "total" => $migrationTotal,
            "msg" => 'Successfully Migrated'
        );
       
        return $response;
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Archive::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
