<?php

namespace frontend\modules\reports\modules\lab\controllers;

use Yii;
use common\models\lab\Testreport;
use common\models\lab\TestreportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Sample;
use yii\data\ActiveDataProvider;
use common\models\lab\Request;
use common\models\lab\Analysis;
use common\models\lab\Customer;
use common\models\lab\Testreportconfig;
use common\models\lab\Lab;
use common\models\lab\TestreportSample;
use common\models\lab\Batchtestreport;
use yii2tech\spreadsheet\Spreadsheet;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

use yii2tech\spreadsheet\Myspreadsheet;
use frontend\modules\reports\modules\lab\templates\Testreportspreadsheet;

/**
 * TestreportController implements the CRUD actions for Testreport model.
 */
class TestreportController extends Controller
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
     * Lists all Testreport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestreportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $dataProvider->sort->defaultOrder = ['testreport_id' => SORT_DESC];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Testreport model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //retrieve the testreportsamples
        $query = TestreportSample::find()->where(['testreport_id'=>$id]);
        $sampledataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $model = $this->findModel($id);

        //retrieve the request
        $request = Request::findOne($model->request_id);

        return $this->render('view', [
            'model' => $model,
            'request'=> $request,
            'trsamples'=>$sampledataProvider,
        ]);
    }

    public function actionReissue($id){
        //retrieve the testreport record
        $testreport = Testreport::findOne($id);

        //issue new record of the test report with "-R" as suffix
        $newtestreport = new Testreport();
        $newtestreport->attributes = $testreport->attributes;
        //get the testconfig
        $tr_config =  Testreportconfig::find()->where(['lab_id'=>$testreport->lab_id,'config_year'=>date('Y')])->one();

         //check for config if the lab is active
        // $tr_config = Testreportconfig::find()->where(['lab_id'=>$request->lab_id,'config_year'=>date('Y')])->one();
        if(!$tr_config){
            // $tr_config->setTestReportSeries();
            Testreportconfig::setTestReportSeries2($testreport->lab_id);
            $tr_config = Testreportconfig::find()->where(['lab_id'=>$testreport->lab_id,'config_year'=>date('Y')])->one();
        }

        //retrieve the lab info using the $tr_config
        $lab = Lab::findOne($tr_config->lab_id);

        //update the testreport number
        $newtestreport->report_num= date('mdY').'-'.$lab->labcode.'-'.$tr_config->getTestReportSeries()."-R";
        //$newtestreport->report_num = $newtestreport->report_num."-R";
        $newtestreport->testreport_id = ""; //to be safe
        $newtestreport->report_date = date('Y-m-d', strtotime(date("Y-m-d")));

        //set the prev and new ids
        $newtestreport->previous_id=$testreport->testreport_id;
       
        if($newtestreport->save()){
            // $testreport->new_id=$newtestreport->testreport_id;
            $testreport->reissue=1;
            $testreport->save(false);
            $tr_config->setTestReportSeries();
            //create new records of testreportsamples too
            $trsamples = TestreportSample::find()->where(['testreport_id'=>$testreport->testreport_id])->all();

            foreach ($trsamples as $trsample) {
                $newtrsample= new TestreportSample();
                $newtrsample->attributes= $trsample->attributes;
                $newtrsample->testreport_sample_id=""; //tobe safe
                $newtrsample->testreport_id =$newtestreport->testreport_id;
                $newtrsample->save();
            }
            return $this->redirect(['view','id'=>$newtestreport->testreport_id]);
        }

        //reused the ids of the samples

        //redirect to action view
    }

    /**
     * Creates a new Testreport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Testreport();

        if ($model->load(Yii::$app->request->post())) {
            //on form submit the lab_id is used as flag for is_multiple
            //get the request id
            $req_id = $model->request_id;
            //query for the request id info//get labid
            $request = Request::findOne($req_id);

            //check for config if the lab is active
            $tr_config = Testreportconfig::find()->where(['lab_id'=>$request->lab_id,'config_year'=>date('Y')])->one();
            if(!$tr_config){
                // $tr_config->setTestReportSeries();
                Testreportconfig::setTestReportSeries2($request->lab_id);
                $tr_config = Testreportconfig::find()->where(['lab_id'=>$request->lab_id,'config_year'=>date('Y')])->one();
            }

            //retrieve the lab info using the $tr_config
            $lab = Lab::findOne($tr_config->lab_id);

            

            //check if multiple
            if($model->lab_id){
                // var_dump($_POST); exit();
                //if multiple //code here

                $Batchtestreport = New Batchtestreport();
                $Batchtestreport->request_id=$model->request_id;
                $Batchtestreport->batch_date=date('Y-m-d', strtotime($model->report_date));
                $tsr_ids = "";
                $rlabid = $request->lab_id;
                //fetch the sample ids involve
                $sampleids =$_POST['selection'];
                foreach ($sampleids as $key => $value) {
                    //make the record of the testreport
                    $newtsreport = New Testreport();
                    $newtsreport->request_id = $model->request_id;
                    $newtsreport->lab_id=$rlabid;
                    $newtsreport->report_date= date('Y-m-d', strtotime($model->report_date));
                    $newtsreport->report_num=date('mdY').'-'.$lab->labcode.'-'.$tr_config->getTestReportSeries();
                    if($newtsreport->save()){
                        $tsr_ids= $tsr_ids.",".$newtsreport->testreport_id;
                        $tr_config->setTestReportSeries();
                        $trsample = new TestreportSample();
                        $trsample->testreport_id=$newtsreport->testreport_id;
                        // $trsample->sample_id=$value['sample_id'];
                        $trsample->sample_id=$value;
                        $trsample->save();
                    }
                 }
                 $Batchtestreport->testreport_ids=substr($tsr_ids, 1);
                 $Batchtestreport->save();
                Yii::$app->session->setFlash('success', 'Testreport Successfully Save!');
                 return $this->redirect(['viewmultiple', 'id' => $Batchtestreport->batchtestreport_id]);
            }else{
                //if not multiple //code here
    
                //update lab id on model
                $model->lab_id=$request->lab_id;

                //retrieve lab code here

                //

                //update the testreport number
                $model->report_num= date('mdY').'-'.$lab->labcode.'-'.$tr_config->getTestReportSeries();
      
                //reformat the report date
                $model->report_date = date('Y-m-d', strtotime($model->report_date));
                if($model->save()){
                    //update the config to increment the series number
                    $tr_config->setTestReportSeries();
                    //save the sample IDS for samples involve
                    $sampleids =$_POST['selection'];
                    foreach ($sampleids as $key => $value) {
                        $trsample = new TestreportSample();
                        $trsample->testreport_id=$model->testreport_id;
                        $trsample->sample_id=$value;
                        $trsample->save();
                     }
                }
            }
                Yii::$app->session->setFlash('success', 'Testreport Successfully Save!');

            return $this->redirect(['view', 'id' => $model->testreport_id]);
        }
		$model->lab_id=1;
        if(Yii::$app->request->isAjax)
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        else
            return $this->render('create', [
                'model' => $model,
            ]);
    }

    public function actionViewmultiple($id){
        $batch = Batchtestreport::findOne($id);
        // $request = Request::find($batch->request_id)->with("customer")->one();
        return $this->render('viewmultiple',[
            'model'=>$batch,
            // 'request'=>$request
            ]);
    }

    /**
     * Updates an existing Testreport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->testreport_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Testreport model.
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
     * Finds the Testreport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testreport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testreport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetlistsamples($id)
    {
        $model= new Sample();
        $query = Sample::find()->where(['request_id' => $id,'active'=> 1]); //need to get the active samples only
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       // $dataProvider->pagination->pageSize=3;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_samples', ['dataProvider'=>$dataProvider]);
        }
        else{
            return $this->render('_samples', ['dataProvider'=>$dataProvider]);
        }

    }

    public function actionPrintview($id,$template)
    {
      //find the record the testreport
      $testreport = Testreport::findOne($id);

      $exporter = new Testreportspreadsheet([
        'template'=>$template,
        'model'=>$testreport
        ]);
      $exporter->loaddoc();
      $exporter->send($testreport->report_num.'.xls');
    }

    //printlabel is created by Bergel Cutara on May 27, 2021
    public function actionPrintlabel2(){

       if(isset($_GET['request_id'])){
        $id = $_GET['request_id'];
        $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
        $testreport = Testreport::findOne($id);
        $testreportsamples = TestreportSample::find()->where(['testreport_id'=>$id])->all();
        $requestquery = Request::find()->where(['request_id' => $testreport->request_id])->one();
        $customer = Customer::findOne($requestquery->customer_id);

        $link=Url::base(true).Url::toRoute(['/lab/request/viewtransaction', 'id' =>$testreport->report_num]);

        foreach ($testreportsamples as $testrepsample) {
            $sample = Sample::findOne($testrepsample->sample_id);
            $limitreceived_date = substr($requestquery['request_datetime'], 0,10);
            // $content="<div class='row'>&nbsp;</div>";
            $content="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<br/>";
            $content.="<div class='pull-right'>";
            $content.= "<table style='font-family: arial;color:#ef9d1;margin-right:100px;font-size:10px;' align='right'>";
            $content.= "<tr>";
            $content.= "<td style='text-align:center' border-size='1'>";
            $content.='<b>scan to verify report</b>';
            $content.= "</td>";
            $content.= "</tr>";
            $content.= "<tr>";
            $content.= "<td style='text-align:center' border-size='1'>";
            $content.='<img src=
"https://chart.googleapis.com/chart?cht=qr&chl='.$link.'&chs=80x80&chld=L|0"
        class="qr-code img-thumbnail img-responsive" /><br/><b>'.$testreport->report_num.'</b>';
            $content.= "</td>";
            $content.= "</tr>";
            $content.= "</table>";   
            $content.= "</div>";
            $p = 'P';
            $defaultheight = 25;
            // $defaultheight+=($acount);
            // $mpdf->_setPageSize([60,$defaultheight], $p);
            $mpdf->AddPage('','','','','',0,0,0,0);
            $mpdf->WriteHTML($content);         
            }
           
            
            // The $p needs to be passed by reference
            
            $mpdf->Output($testreport->report_num.'.pdf','I');
       }
    }

    //printlabel is created by Bergel Cutara on dec 6, 2021
    public function actionPrintlabel3(){

       if(isset($_GET['request_id'])){
        $id = $_GET['request_id'];
        $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
        $testreport = Testreport::findOne($id);
        $testreportsamples = TestreportSample::find()->where(['testreport_id'=>$id])->all();
        $requestquery = Request::find()->where(['request_id' => $testreport->request_id])->one();
        $customer = Customer::findOne($requestquery->customer_id);

        $link=Url::base(true).Url::toRoute(['/lab/request/viewtransaction', 'id' =>$testreport->report_num]);

        foreach ($testreportsamples as $testrepsample) {
            $sample = Sample::findOne($testrepsample->sample_id);
            $limitreceived_date = substr($requestquery['request_datetime'], 0,10);
            // $content="<div class='row'>&nbsp;</div>";
            
            $content="<div style='text-align:center;'>";
            $content.= "<table style='font-family: arial;color:#ef9d1;font-size:10px;text-align:center'>";
            $content.= "<tr>";
            $content.= "<td style='text-align:center' border-size='1'>";
            $content.='<b>scan to verify report</b>';
            $content.= "</td>";
            $content.= "</tr>";
            $content.= "<tr>";
            $content.= "<td style='text-align:center' border-size='1'>";
            $content.='<img src=
"https://chart.googleapis.com/chart?cht=qr&chl='.$link.'&chs=80x80&chld=L|0"
        class="qr-code img-thumbnail img-responsive" /><br/><b>'.$testreport->report_num.'</b>';
            $content.= "</td>";
            $content.= "</tr>";
            $content.= "</table>";   
            $content.= "</div>";
            $p = 'P';
            // $defaultheight+=($acount);
            $mpdf->_setPageSize([30, 35], $p);
            $mpdf->AddPage('','','','','',0,0,0,0);
            $mpdf->WriteHTML($content);         
            }
           
            
            // The $p needs to be passed by reference
            
            $mpdf->Output($testreport->report_num.'.pdf','I');
       }
    }
}
