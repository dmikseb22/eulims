<?php
namespace frontend\modules\lab\controllers;
use Yii;
use common\models\lab\Analysis;
use common\models\lab\Sample;
use common\models\lab\Request;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use common\models\lab\Lab;
use common\models\lab\Labsampletype;
use common\models\lab\Sampletype;
use common\models\lab\Sampletypetestname;
use common\models\lab\Testnamemethod;
use common\models\lab\Methodreference;
use common\models\lab\Testname;
use yii\data\ArrayDataProvider;


/**
 * AnalysisController implements the CRUD actions for Analysis model.
 */
class ApiController extends Controller
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
     * Lists all Analysis models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnalysisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //Server Status
    public function actionStatus($server)
    {  
      
            if(!$sock = @fsockopen($server, 80))
            {
                $data = array("status" => "Offline");
            }
            else
            {
                $data = array("status" => "Online");
            }

            return $this->asJson($data);
       
   }  

   //Login
  public function actionLogin()
  {  

    // Sample POST Data:
    // {
    // "email": "anecbook@gmail.com",
    // "password": "123456"
    // }

            $data = array ("token"=>"W29iamVjdCBPYmplY3Rd", 
            "user"=>array("email"=>"bernadettebucoybelamide@gmail.com",
            "firstName"=>"Bernadette",
            "middleInitial"=>"B",
            "lastName"=> "Bucoy",
            "userType"=> "CRO"
        ));
            return $this->asJson($data);   
            //return $u.$p;
  }  

 public function actionUser()
  {  
    // Sample GET Data:

    // {
    //   "token": "abcde12345"
    // }


    $data = array("token"=>"abcde12345", "q"=> "CHE-08");
    return $this->asJson($data);  
 }  

 public function actionSamplecode()
  {  
         $model = new Sample();    
        

             if (!isset($_GET['rstl_id'])){
                 $rstl = 11;
                 $year = 2019;
             }else{
                 $rstl = (int) $_GET['rstl_id'];
                 $year = (int) $_GET['year'];
             }
                 $data = $model::find()
                      ->leftJoin('tbl_request', 'tbl_sample.request_id=tbl_request.request_id') 
                      ->where(['tbl_request.rstl_id'=>$rstl]) 
                      ->AndWhere(['like', 'request_ref_num', '%'.$year.'%', false]) 
                      ->count();
                
                     return $data;
 }  

 public function actionAnalysis()
  {  
    // Sample GET Data:

    // {
    //   "token": "abcde12345",
    //   "id": "CHE-0812"
    // }

    //{
    //     "sampleCode": "CHE-0812",
    //     "samples": [
    //       {
    //         "name": "Oil",
    //         "description": "Scheme: QFCS, Round: FC221, Sample: 778-Fat Quality Storage: 2-8 C, approx. 150 g sample, in an amber glass bottle."
    //       }
    //     ],
    //     "tests": [
    //       {
    //         "id": 1,
    //         "name": "Package B",
    //         "method": null,
    //         "progress": 0,
    //         "workflow": 6,
    //         "status": "pending",
    //         "procedures": [
    //           {
    //             "procedure": "Oxidation",
    //             "startDate": "2019-04-29",
    //             "endDate": "2019-04-29",
    //             "status": "pending"
    //           }
    //         ]
    //       }
    //     ]
    //   }
      
    //   // If sample code does NOT exist
    //   {
    //     "error": "Sample code does not exist."
    //   }
 }  

    /**
     * Displays a single Analysis model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

}
