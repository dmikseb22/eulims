<?php

namespace frontend\modules\setup\controllers;

use Yii;


/**
 * PackagelistController implements the CRUD actions for Packagelist model.
 */
class SetupController extends Controller
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
     * Lists all Packagelist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackagelistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Packagelist model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]);
        }
    }

    /**
     * Creates a new Packagelist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
     $model = new Packagelist();

    //  $request_id = $_GET['id'];

    //   $request = $this->findRequest($request_id);
    //   $labId = $request->lab_id;

      $testcategory = $this->listTestcategory(1);
      $sampletype = [];

                 if ($model->load(Yii::$app->request->post())) {

                         $post= Yii::$app->request->post();
                        $packagelist = new Packagelist();
                        $packagelist->rstl_id = (int) $post['Packagelist']['rstl_id'];
                        $packagelist->lab_id = (int) $post['Packagelist']['testcategory_id'];
                        $packagelist->testcategory_id = $post['Packagelist']['testcategory_id'];
                        $packagelist->sample_type_id = $post['Packagelist']['sample_type_id'];
                        $packagelist->name = $post['Packagelist']['name'];
                        $packagelist->rate = $post['Packagelist']['rate'];  
                        $packagelist->tests = $post['Packagelist']['tests']; 
                        $packagelist->save();
                        Yii::$app->session->setFlash('success', 'Package Successfully Added');
                        return $this->runAction('index');
               
                    }      
                                
                     
                if(Yii::$app->request->isAjax){
                         return $this->renderAjax('_form', [
                                 'model' => $model,
                                 'testcategory'=>$testcategory,
                                 'sampletype'=>$sampletype,
                             ]);
                     }
    }

  
    public function actionCreatepackage($id)
    {
        $model = new Packagelist();
        $request_id = $_GET['id'];
        $searchModel = new PackageListSearch();
        $session = Yii::$app->session;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post())) {
            $sample_ids= $_POST['sample_ids'];
            $ids = explode(',', $sample_ids);  
            $post= Yii::$app->request->post();       
            }
            $samplesQuery = Sample::find()->where(['request_id' => $id]);
            $sampleDataProvider = new ActiveDataProvider([
                    'query' => $samplesQuery,
                    'pagination' => [
                        'pageSize' => false,
                               ],             
            ]);

            $request = $this->findRequest($request_id);
            $labId = $request->lab_id;
            $testcategory = $this->listTestcategory($labId);
         
            $sampletype = [];
            $test = [];

         if ($model->load(Yii::$app->request->post())) {
                 $sample_ids= $_POST['sample_ids'];
                 $ids = explode(',', $sample_ids);  
                 $post= Yii::$app->request->post();

                   

                 foreach ($ids as $sample_id){  

                     $p = $post['Packagelist']['name'];
                     $r = str_replace("," , "", $post['Packagelist']['rate']);

                     $Connection= Yii::$app->labdb;
                     $sql="UPDATE `tbl_sample` SET `package_id`=$p, `package_rate`='$r' WHERE `sample_id`=".$sample_id;
                     $Command=$Connection->createCommand($sql);
                     $Command->execute();

                     $analysis = new Analysis();
                     $modelpackage =  Package::findOne(['id'=>$post['Packagelist']['name']]);

                     $analysis->sample_id = $sample_id;
                     $analysis->cancelled = 0;
                     $analysis->pstcanalysis_id = $GLOBALS['rstl_id'];
                     $analysis->request_id = $request_id;
                     $analysis->rstl_id = $GLOBALS['rstl_id'];
                     $analysis->test_id = 0;
                     $analysis->user_id = 1;
                     $analysis->type_fee_id = 2;
                     $analysis->sample_type_id = (int) $post['Packagelist']['sample_type_id'];
                     $analysis->testcategory_id = 0;
                     $analysis->is_package = 1;
                     $analysis->method = "-";
                     $analysis->category_id = 1;
                     $analysis->fee = $r;
                     $analysis->testname = $modelpackage->name;
                     $analysis->references = "-";
                     $analysis->quantity = 1;
                     $analysis->sample_code = "sample";
                     $analysis->date_analysis = '2018-06-14 7:35:0';   
                     $analysis->save();

                     $testname_id = $_POST['package_ids'];
                     $test_ids = explode(',', $testname_id);  

                     foreach ($test_ids as $t_id){

                        $analysis_package = new Analysis();
                        $testnamemethod =  Testnamemethod::findOne(['testname_method_id'=>$t_id]);
                        $modeltest=  Testname::findOne(['testname_id'=>$testnamemethod->testname_id]);
                        $methodreference =  Methodreference::findOne(['method_reference_id'=>$testnamemethod->method_id]);

                        $modelmethod=  Methodreference::findOne(['testname_id'=>$t_id]);
                        $analysis_package->sample_id = $sample_id;
                        $analysis_package->cancelled = 0;
                        $analysis_package->pstcanalysis_id = Yii::$app->user->identity->profile->rstl_id;
                        $analysis_package->request_id = $request_id;
                        $analysis_package->rstl_id = Yii::$app->user->identity->profile->rstl_id;
                        $analysis_package->test_id = $t_id;
                        $analysis_package->user_id = 1;
                        $analysis_package->type_fee_id = 2;
                        $analysis_package->sample_type_id = (int) $post['Packagelist']['sample_type_id'];
                        $analysis_package->category_id = 1;
                        $analysis_package->testcategory_id = $methodreference->method_reference_id;
                        $analysis_package->is_package = 1;
                        $analysis_package->method = $methodreference->method;
                       // $analysis->method = $modelmethod->method;
                        $analysis->category_id = 1;
                        $analysis_package->fee = 0;
                        $analysis_package->testname = $modeltest->testName;
                        $analysis_package->references = $methodreference->reference;
                        $analysis_package->quantity = 1;
                        $analysis_package->sample_code = "sample";
                        $analysis_package->date_analysis = '2018-06-14 7:35:0';   
                        $analysis_package->save(false);

                      
                    }      
                 }                   
                 Yii::$app->session->setFlash('success', 'Package Succesfull Added');
                 return $this->redirect(['/lab/request/view', 'id' =>$request_id]);
        } 
        if (Yii::$app->request->isAjax) {

            $analysismodel = new Analysis();
            $analysismodel->rstl_id = $GLOBALS['rstl_id'];
            $analysismodel->pstcanalysis_id = $GLOBALS['rstl_id'];
            $analysismodel->request_id = $GLOBALS['rstl_id'];
            $analysismodel->testname = $GLOBALS['rstl_id'];
            $analysismodel->cancelled = 0;
            $analysismodel->is_package = 1;
            $analysismodel->sample_id = $GLOBALS['rstl_id'];
            $analysismodel->sample_code = $GLOBALS['rstl_id'];
            $analysismodel->date_analysis = '2018-06-14 7:35:0';

            return $this->renderAjax('_packageform', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'test' => $test,
                'sampletype'=>$sampletype
            ]);
        }else{
            $model->rstl_id = $GLOBALS['rstl_id'];
            return $this->render('_packageform', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'test' => $test,
                'sampletype'=>$sampletype
            ]);
        }
    }

    public function actionListpackage()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            //$list = Package::find()->andWhere(['sampletype_id'=>$id])->asArray()->all();

            $list =  Package::find()
            ->innerJoin('tbl_sampletype', 'tbl_sampletype.sampletype_id=tbl_package.sampletype_id')
            ->Where(['tbl_package.sampletype_id'=>2])
            ->asArray()
            ->all();

            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $package) {
                    $out[] = ['id' => $package['id'], 'name' => $package['name']];
                    if ($i == 0) {
                        $selected = $package['id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    protected function findRequest($requestId)
    {
        if (($model = Request::findOne($requestId)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetpackage() {


    if ($_GET['packagelist_id']){
        if(isset($_GET['packagelist_id'])){
            $id = (int) $_GET['packagelist_id'];
            $modelpackagelist =  Package::findOne(['id'=>$id]);
            $tet = $modelpackagelist->tests;

             
                if(count($modelpackagelist)>0){
                    $rate = number_format($modelpackagelist->rate,2);
                             
                    // $sql = "SELECT GROUP_CONCAT(testName) FROM tbl_testname WHERE testname_id IN ($tet)";     
         
                    // $Connection = Yii::$app->labdb;
                    // $command = $Connection->createCommand($sql);
                    // $row = $command->queryOne();    
                    //     $tests = $row['GROUP_CONCAT(testName)'];   
                    
                    
                  
                        $sql = "SELECT GROUP_CONCAT(testname_id) FROM tbl_testname_method WHERE testname_method_id IN ($tet)";     
             
                        $Connection = Yii::$app->labdb;
                        $command = $Connection->createCommand($sql);
                        $row = $command->queryOne();    
                        $tests = $row['GROUP_CONCAT(testname_id)'];  

                        $space = explode(',', $tests);
                        $d = '';
                        $newline = ", ";
                        foreach ($space as $s){
                            $d.= $s.$newline;
                        }

                        $len = strlen($d);

                        $x = $len-2;

                        $testname_id = substr($d ,0,$x);
                        $sql_testname = "SELECT GROUP_CONCAT(testName) FROM tbl_testname WHERE testname_id IN ($testname_id)";     
             
                        $Connection = Yii::$app->labdb;
                        $command_testname = $Connection->createCommand($sql_testname);
                        $row_testname = $command_testname->queryOne();    
                        $tests = $row_testname['GROUP_CONCAT(testName)'];  

                      
                 

                } else {
                    $rate = "";
                    $tests = "";
                    
                }
            } else {
                $rate = "Error getting rate";
                $tests = "Error getting tests";
            }
            
            return Json::encode([
                'rate'=>$rate,
                'tests'=>$tests,
                'ids'=>$tet,
            ]);
              }else{
                  $x = 0;
                return Json::encode([
                    'rate'=>$x,
                    'tests'=>'None',
                    'ids'=>$x,
                ]);
              }

           
    }

    protected function listTestcategory($labId)
    {
        $testcategory = ArrayHelper::map(
           Sampletype::find()
           ->leftJoin('tbl_lab_sampletype', 'tbl_lab_sampletype.sampletype_id=tbl_sampletype.sampletype_id')
           ->andWhere(['lab_id'=>$labId])
           ->all(), 'sampletype_id', 
           function($testcategory, $defaultValue) {
               return $testcategory->type;
        });

        return $testcategory;
    }
    /**
     * Updates an existing Packagelist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $testcategory = $this->listTestcategory(1);
        $sampletype = [];

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Package Successfully Updated');
                    return $this->runAction('index');
                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('_form', [
                        'model' => $model,
                        'testcategory'=>$testcategory,
                        'sampletype'=>$sampletype,
                    ]);
                }
    }

    /**
     * Deletes an existing Packagelist model.
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
     * Finds the Packagelist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Packagelist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Packagelist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function listSampletype()
    {
        $sampletype = ArrayHelper::map(
            Packagelist::find()
            ->leftJoin('tbl_sampletype', 'tbl_sampletype.sampletype_id=tbl_package.sampletype_id')
            ->Where(['tbl_package.sampletype_id'=>2])
            ->all(), 'id', 
            function($sampletype, $defaultValue) {
                return $sampletype->name;
        });

        return $sampletype;
    }

    
    public function actionListsampletype() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
          
            $list =   Package::find()
            ->leftJoin('tbl_sampletype', 'tbl_sampletype.sampletype_id=tbl_package.sampletype_id')
            ->Where(['tbl_package.sampletype_id'=>$id])
            ->asArray()
            ->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $sampletype) {
                    $out[] = ['id' => $sampletype['id'], 'name' => $sampletype['name']];
                    if ($i == 0) {
                        $selected = $sampletype['id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

}
