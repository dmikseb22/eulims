<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Accountingcodemapping;
use common\models\finance\AccountingcodemappingSearch;
use common\models\finance\AccountcodeWithoutMapping;
use common\models\finance\AccountcodeCollection;
use common\models\finance\Collectiontype;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;



/**
 * AccountingcodemappingController implements the CRUD actions for Accountingcodemapping model.
 */
class AccountingcodemappingController extends Controller
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
     * Lists all Accountingcodemapping models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new AccountingcodemappingSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //return $this->render('index', [
        //    'searchModel' => $searchModel,
        //    'dataProvider' => $dataProvider,
       // ]);
        
      $model = new Accountingcodemapping();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->mapping_id]);
        }
        
        $sql = "Call spGetAccountCodeWithoutMapping()";
        
        $modelAccountCode = new AccountcodeWithoutMapping();
        $dataProviderAccountCode = ArrayHelper::map(Yii::$app->financedb->createCommand($sql)->queryAll(),'accountingcode_id','accountcode');

        $modelCollectionType = new Collectiontype();
        $dataProviderCollectionType= ArrayHelper::map(Collectiontype::find()->all(),'collectiontype_id','natureofcollection');
        
        $sqlGrid = "Call spGetAccountMapping()";
        $modelAccountCollection = new AccountcodeCollection();
       // $dataProviderAccountCollection =  Yii::$app->financedb->createCommand($sqlGrid)->queryAll();
        
      //  $dataProviderAccountCollection = new SqlDataProvider([
    //'sql' => 'Call spGetAccountMapping()']);
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM eulims_finance.tbl_accountingcodemapping')->queryScalar();

        $dataProviderAccountCollection = new SqlDataProvider([
            'sql' => 'Call eulims_finance.spGetAccountMapping();',
            
            'totalCount' => $count,
           'pagination' => [
                'pageSize' => 5
            ],
           
        ]);
        
     //  $dataProviderAccountCollection->setTotalCount($count);
        
        if (Yii::$app->request->isAjax)
        {
        return $this->renderAjax('index', [
            'model' => $model,
            'modelAccountCode' =>  $modelAccountCode,
            'dataProviderAccountCode' => $dataProviderAccountCode,
            'modelCollectionType' =>$modelCollectionType,
            'dataProviderCollectionType' =>$dataProviderCollectionType,
            'modelAccountCollection' => $modelAccountCollection,
            'dataProviderAccountCollection' => $dataProviderAccountCollection
        ]);
        }
        
        else
            
        {
            return $this->redirect(['accountingcode/index']);
           
        }
    }
    
    public function actionCreate()
    {
        
        $model = new Accountingcodemapping();

        if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                    
                            $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM eulims_finance.tbl_accountingcode ac
            LEFT JOIN eulims_finance.tbl_accountingcodemapping acm ON ac.`accountingcode_id`=acm.`accountingcode_id`
            LEFT JOIN eulims_finance.tbl_collectiontype ct ON acm.`collectiontype_id` = ct.`collectiontype_id`
            ORDER BY ac.accountingcode_id ')->queryScalar();
            $queryNew = new yii\db\Query;


                              $queryNew->select('eulims_finance.tbl_accountingcode.accountcode, eulims_finance.tbl_collectiontype.natureofcollection')
                              ->from('eulims_finance.tbl_accountingcode')
                              ->leftJoin('eulims_finance.tbl_accountingcodemapping', 'eulims_finance.tbl_accountingcode.accountingcode_id = eulims_finance.tbl_accountingcodemapping.accountingcode_id')    
                              ->leftJoin('eulims_finance.tbl_collectiontype', 'eulims_finance.tbl_accountingcodemapping.collectiontype_id = eulims_finance.tbl_collectiontype.collectiontype_id')
                              ->orderBy('eulims_finance.tbl_accountingcode.accountingcode_id');
                                
                               $dataProvider= new ActiveDataProvider([
                                  'query' => $queryNew,
                                   'totalCount' => $count,
                               'pagination' => [
                                      'pageSize' => 6
                                  ],

                              ]);


               return $this -> redirect(['/finance/accountingcode/index']);                 
      
                                
                               
                                 
        }
        
        $sql = "Call spGetAccountCodeWithoutMapping()";
        
        $modelAccountCode = new AccountcodeWithoutMapping();
        $dataProviderAccountCode = ArrayHelper::map(Yii::$app->financedb->createCommand($sql)->queryAll(),'accountingcode_id','accountcode');

        $modelCollectionType = new Collectiontype();
        $dataProviderCollectionType= ArrayHelper::map(Collectiontype::find()->all(),'collectiontype_id','natureofcollection');
        
        $sqlGrid = "Call spGetAccountMapping()";
        $modelAccountCollection = new AccountcodeCollection();
       // $dataProviderAccountCollection =  Yii::$app->financedb->createCommand($sqlGrid)->queryAll();
        
      //  $dataProviderAccountCollection = new SqlDataProvider([
    //'sql' => 'Call spGetAccountMapping()']);
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM eulims_finance.tbl_accountingcodemapping')->queryScalar();
        
       $queryA = new yii\db\Query;
        $queryNew =  'Call eulims_finance.spGetAccountMapping();';
       
        $dataProvider2 = new SqlDataProvider([
            'sql' => $queryNew,
            
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5
            ],
          
        ]);
        
      
        
        $queryNew = new yii\db\Query;
       // $queryNew ='SELECT ac.accountcode,ct.natureofcollection FROM eulims_finance.tbl_accountingcode ac INNER JOIN eulims_finance.tbl_accountingcodemapping acm ON ac.accountingcode_id=acm.accountingcode_id INNER JOIN eulims_finance.tbl_collectiontype ct ON acm.collectiontype_id = ct.collectiontype_id';
 
        // $bayar = Yii::$app->db->createCommand('SELECT ac.accountcode,ct.natureofcollection FROM eulims_finance.tbl_accountingcode ac INNER JOIN eulims_finance.tbl_accountingcodemapping acm ON ac.accountingcode_id=acm.accountingcode_id INNER JOIN eulims_finance.tbl_collectiontype ct ON acm.collectiontype_id = ct.collectiontype_id');

        $queryNew->select('accountcode, natureofcollection')
        ->from('eulims_finance.tbl_accountingcode')
        ->innerJoin('eulims_finance.tbl_accountingcodemapping', 'eulims_finance.tbl_accountingcode.accountingcode_id = eulims_finance.tbl_accountingcodemapping.accountingcode_id')    
        ->innerJoin('eulims_finance.tbl_collectiontype', 'eulims_finance.tbl_accountingcodemapping.collectiontype_id = eulims_finance.tbl_collectiontype.collectiontype_id');
                
         $dataProvider= new ActiveDataProvider([
            'query' => $queryNew,
             'totalCount' => $count,
         'pagination' => [
                'pageSize' => 5
            ],
          
        ]);
    
        if (Yii::$app->request->isAjax)
        {
        return $this->renderAjax('create', [
            'model' => $model,
            'modelAccountCode' =>  $modelAccountCode,
            'dataProviderAccountCode' => $dataProviderAccountCode,
            'modelCollectionType' =>$modelCollectionType,
            'dataProviderCollectionType' =>$dataProviderCollectionType,
            'modelAccountCollection' => $modelAccountCollection,
            'dataProvider' => $dataProvider
        ]);
        }
        
        else
            
        {
           return $this->redirect(['accountingcode/index']);
        }
    }
    
    public function actionCollectionfilter() {
    
    
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $accountingcode_ID = $parents[0];
       
         
          $result = Yii::$app->db->createCommand("CALL eulims_finance.spGetCollectionTypeWithoutAccount(:accountingcodeID)") 
                      ->bindValue(':accountingcodeID' , $accountingcode_ID )
                      ->queryAll();
         
         
            echo \yii\helpers\Json::encode(['output'=>$result, 'selected'=>''],JSON_UNESCAPED_SLASHES);
            return;
        }
    }
  
   
    echo \yii\helpers\Json::encode(['output'=>'', 'selected'=>'']);
    return;
}


public function actionAccount() {
    $out = [];
     $modelCollectionType = new Collectiontype();
  //  $dataProviderCollectionType= ArrayHelper::map(Collectiontype::find()->all(),'collectiontype_id','natureofcollection');
    
     $dataProviderCollectionType= Collectiontype::find()->all();
    
    
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            //$cat_id = $parents[0];
          //  $out = self::getSubCatList($cat_id); 
        
         $out= $dataProviderCollectionType;
            
         $test =  [
              ['collectiontype_id'=>'1', 'natureofcollection'=>'mariano'],
              ['collectiontype_id'=>'2', 'natureofcollection'=>'testing']
             ];
         
         
            echo \yii\helpers\Json::encode(['output'=>$out, 'selected'=>''],JSON_UNESCAPED_SLASHES);
            return;
        }
    }
    
    $out = [
    ['id'=>2, 'name'=>'Analysis/Calibration'],
    ['id'=>3, 'name'=>'Pretoria'],
   // and so on
];
   
    echo \yii\helpers\Json::encode(['output'=>$dataProviderCollectionType, 'selected'=>'test'],JSON_UNESCAPED_SLASHES);
}
    

    /**
     * Displays a single Accountingcodemapping model.
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
     * Creates a new Accountingcodemapping model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    
     public function actionDropdown()
    {
    //$db = 'financedb';
    //     $searchModel = new PackageDetailsSearch();
    //    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $sql = "Call spGetAccountCodeWithoutMapping()";
        $modelAccountCode = new AccountcodeWithoutMapping();
        $dataProviderAccountCode = ArrayHelper::map(Yii::$app->financedb->createCommand($sql)->queryAll(),'accountingcode_id','accountcode');

        $modelCollectionType = new Collectiontype();
        $dataProviderCollectionType= ArrayHelper::map(Collectiontype::find()->all(),'collectiontype_id','natureofcollection');
        
        return $this->render('dropdown', [
            'modelAccountCode' =>  $modelAccountCode,
            'dataProviderAccountCode' => $dataProviderAccountCode,
            'modelCollectionType' =>$modelCollectionType,
           'dataProviderCollectionType' =>$dataProviderCollectionType
        ]);
    }

    /**
     * Updates an existing Accountingcodemapping model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          //  return $this->redirect(['view', 'id' => $model->mapping_id]);
          //  return $this->refresh();
           return $this->redirect(['/finance/accountingcode/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Accountingcodemapping model.
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
     * Finds the Accountingcodemapping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accountingcodemapping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Accountingcodemapping::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
}
