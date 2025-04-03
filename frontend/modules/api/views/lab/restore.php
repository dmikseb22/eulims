


<?php
use yii\helpers\Html;
use yii\bootstrap\Progress;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Customer;
use common\models\lab\Restore_customer;
use common\models\lab\Services;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Backuprestore;
use common\models\lab\Lab;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use common\components\Functions;
use linslin\yii2\curl;
use yii\helpers\Json;



/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\ServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$func=new Functions();


$this->title = 'Laboratory Module Restore';
$this->params['breadcrumbs'][] = ['label' => 'API', 'url' => ['/api']];
$this->params['breadcrumbs'][] = $this->title;
   



?>   

<fieldset>
    <legend>Legend/Status</legend>
    <div>
    <span class='badge btn-success legend-font' ><span class= 'glyphicon glyphicon-check'></span> DONE</span>
    <span class='badge btn-danger legend-font' ><span class= 'glyphicon glyphicon-check'></span> PENDING</span>

                
    </div>
</fieldset>
   
    <div class="row">
    <div class="image-loader" style="display: hidden;"></div>
   
    </div>
    
    <div class = "row" style="padding-left:15px;padding-right:15px" id="methodreference">
  
    <?= 
    GridView::widget([
        'dataProvider' => $restoredataprovider,
        'id'=>'restore-grid',
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> "<span class='btn btn-primary' onclick='restoreyear(2015)'>SYNC</span>",
               'after'=>false,
            ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],     
            [
                'header'=>'Year',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                          return "<b>".$model->year;
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],           
            ],
            // [
            //     'header'=>'Customer',
            //     'hAlign'=>'center',
            //     'format'=>'raw',
            //     'value' => function($model) {
                     
            //             $customer = Customer::find()->count();

            //             //customer
            //             $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
            //             $apiUrl_customer="https://eulimsapi.onelab.ph/api/web/v1/customers/countcustomer?rstl_id=".$GLOBALS['rstl_id'];        
            //             $curl_customer = curl_init();			
            //             curl_setopt($curl_customer, CURLOPT_URL, $apiUrl_customer);
            //             curl_setopt($curl_customer, CURLOPT_SSL_VERIFYPEER, FALSE);
            //             curl_setopt($curl_customer, CURLOPT_SSL_VERIFYHOST, FALSE); 
            //             curl_setopt($curl_customer, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
            //             curl_setopt($curl_customer, CURLOPT_RETURNTRANSFER, true);
            //             $response_customer = curl_exec($curl_customer);			
            //             $data_customer = json_decode($response_customer, true);

            //             return number_format($customer)."/".number_format($data_customer);
            //     },
            //     'enableSorting' => false,
            //     'contentOptions' => ['style' => 'width:10px; white-space: normal;'],           
            // ],
            [
                'header'=>'Request',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {

                          $request = Request::find()
                          ->Where(['like', 'request_ref_num', '%'.$model->year.'%', false])
                          ->count();

                          $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                          $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/countrequest?rstl_id=".$GLOBALS['rstl_id']."&year=".$model->year;       
                          $curl = curl_init();			
                          curl_setopt($curl, CURLOPT_URL, $apiUrl);
                          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
                          curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                          $response = curl_exec($curl);			
                          $data = json_decode($response, true);
                         return $request."/".number_format($data);
                         
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],           
            ],
            [
                'header'=>'Sample',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                         $sample = Sample::find()
                         ->leftJoin('tbl_request', 'tbl_sample.request_id=tbl_request.request_id')  
                         ->Where(['like', 'request_ref_num', '%'.$model->year.'%', false])
                         ->count();

                         $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                         $apiUrl_sample="https://eulimsapi.onelab.ph/api/web/v1/samples/countsample?rstl_id=".$GLOBALS['rstl_id']."&year=".$model->year;
                         $curl_sample = curl_init();			
                         curl_setopt($curl_sample, CURLOPT_URL, $apiUrl_sample);
                         curl_setopt($curl_sample, CURLOPT_SSL_VERIFYPEER, FALSE);
                         curl_setopt($curl_sample, CURLOPT_SSL_VERIFYHOST, FALSE); 
                         curl_setopt($curl_sample, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                         curl_setopt($curl_sample, CURLOPT_RETURNTRANSFER, true);
                         $response_sample = curl_exec($curl_sample);			
                         $data_sample = json_decode($response_sample, true);

                          return number_format($sample)."/".number_format($data_sample);
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],           
            ],
            [
                'header'=>'Analysis',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                          $analysis = Analysis::find()
                          ->AndWhere(['like', 'date_analysis', '%'.$model->year.'%', false])
                          ->count();

                          $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                          $apiUrl_analysis="https://eulimsapi.onelab.ph/api/web/v1/analysisdatas/countanalysis?rstl_id=".$GLOBALS['rstl_id']."&year=".$model->year;
                          $curl_analysis = curl_init();			
                          curl_setopt($curl_analysis, CURLOPT_URL, $apiUrl_analysis);
                          curl_setopt($curl_analysis, CURLOPT_SSL_VERIFYPEER, FALSE);
                          curl_setopt($curl_analysis, CURLOPT_SSL_VERIFYHOST, FALSE); 
                          curl_setopt($curl_analysis, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                          curl_setopt($curl_analysis, CURLOPT_RETURNTRANSFER, true);
                          $response_analysis = curl_exec($curl_analysis);			
                          $data_analysis = json_decode($response_analysis, true);

                          return number_format($analysis)."/".number_format($data_analysis);
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],           
            ],
            // [
            //     'header'=>'Truncate',
            //     'hAlign'=>'center',
            //     'format'=>'raw',
            //     'value' => function($model) {
            //               return "<span class='btn btn-warning' id='offer' onclick='unofferservices(1)'>TRUNCATE</span>";
            //     },
            //     'enableSorting' => false,
            //     'contentOptions' => ['style' => 'width:10%; white-space: normal;'],           
            // ],
            [
                'header'=>'Action',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {        
                    return "<span class='btn btn-primary' onclick='restoreyear(".$model->year.")'>SYNC</span>";      
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],           
            ],
            [
                'header'=>'Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {

                    //request
                    $request = Request::find()
                    ->Where(['like', 'request_ref_num', '%'.$model->year.'%', false])
                    ->count();

                    $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                    $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/countrequest?rstl_id=".$GLOBALS['rstl_id']."&year=".$model->year;       
                    $curl = curl_init();			
                    curl_setopt($curl, CURLOPT_URL, $apiUrl);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
                    curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($curl);			
                    $data = json_decode($response, true);

                    //sample
                    $sample = Sample::find()
                    ->leftJoin('tbl_request', 'tbl_sample.request_id=tbl_request.request_id')  
                    ->Where(['like', 'request_ref_num', '%'.$model->year.'%', false])
                    ->count();

                    $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                    $apiUrl_sample="https://eulimsapi.onelab.ph/api/web/v1/samples/countsample?rstl_id=".$GLOBALS['rstl_id']."&year=".$model->year;
                    $curl_sample = curl_init();			
                    curl_setopt($curl_sample, CURLOPT_URL, $apiUrl_sample);
                    curl_setopt($curl_sample, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($curl_sample, CURLOPT_SSL_VERIFYHOST, FALSE); 
                    curl_setopt($curl_sample, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                    curl_setopt($curl_sample, CURLOPT_RETURNTRANSFER, true);
                    $response_sample = curl_exec($curl_sample);			
                    $data_sample = json_decode($response_sample, true);

                    //analysis
                    $analysis = Analysis::find()
                    ->AndWhere(['like', 'date_analysis', '%'.$model->year.'%', false])
                    ->count();

                    $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                    $apiUrl_analysis="https://eulimsapi.onelab.ph/api/web/v1/analysisdatas/countanalysis?rstl_id=".$GLOBALS['rstl_id']."&year=".$model->year;
                    $curl_analysis = curl_init();			
                    curl_setopt($curl_analysis, CURLOPT_URL, $apiUrl_analysis);
                    curl_setopt($curl_analysis, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($curl_analysis, CURLOPT_SSL_VERIFYHOST, FALSE); 
                    curl_setopt($curl_analysis, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); 
                    curl_setopt($curl_analysis, CURLOPT_RETURNTRANSFER, true);
                    $response_analysis = curl_exec($curl_analysis);			
                    $data_analysis = json_decode($response_analysis, true);


                    if (($request==$data) && ($sample==$data_sample) && ($analysis==$data_analysis) ){
                        return "<span class='badge btn-success' style='width:90px;height:20px'>COMPLETED</span>";
                    }else   
                        return "<span class='badge btn-danger' style='width:90px;height:20px'>PENDING</span>";
                   
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:5%; white-space: normal;'],           
            ],

            [
                'header'=>'Remarks',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                   // return "<span class='badge btn-default' style='width:90px;height:20px'>PENDING</span>";

                   return "";
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:15%; white-space: normal;'],           
            ],
        ],
    ]);
    ?>
</div>



<style type="text/css">
/* Absolute Center Spinner */
.img-loader {
    position: fixed;
    z-index: 999;
    /*height: 2em;
    width: 2em;*/
    height: 64px;
    width: 64px;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: url('/images/img-loader64.gif');
    background-repeat: no-repeat;
}
/* Transparent Overlay */
.img-loader:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
}
</style>

<script type="text/javascript">

    function restoreyear(year){

        
        $.ajax({
            url: "/api/lab/restoreyear",
            method: "POST",
            dataType: 'json',
            data: { year:year},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( data ) {
                alert(data.message);
                $("#restore-grid").yiiGridView("applyFilter"); 

                $('.image-loader').removeClass("img-loader");
            });
        }

</script>
