


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

$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$year = ['2013', '2014', '2015', '2016', '2017', '2018', '2019'];

$this->title = 'Laboratory Module Restore';
$this->params['breadcrumbs'][] = ['label' => 'API', 'url' => ['/api']];
$this->params['breadcrumbs'][] = $this->title;
   
      
// $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=11&reqds=2013-01-01&reqde=2013-01-31&pp=5&page=1";

//             $curl = curl_init();                   
//             curl_setopt($curl, CURLOPT_URL, $apiUrl);
//             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
//             curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
//             curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
//             curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//             $response = curl_exec($curl);
                
//             $data = json_decode($response, true);
        
//               foreach ($data as $request)
//               {
//                         foreach ($request['customer'] as $customer){
//                         echo $customer['customer_name']." ".$customer['customer_id']." ".$customer['customer_old_id']."<br>";
                        // $newcustomer = new Restore_customer();
                        // $cus = Customer::find()->where([ 'customer_name'=>  $customer['customer_name']])->all();
                        // if ($cus){
                            
                        // }else{
                        //     $newcustomer->customer_id = $customer['customer_id'];
                        //     $newcustomer->rstl_id = $customer['rstl_id'];
                        //     $newcustomer->customer_code = $customer['customer_code'];
                        //     $newcustomer->customer_name = $customer['customer_name'];
                        //     $newcustomer->classification_id = $customer['classification_id'];
                        //     $newcustomer->latitude = $customer['latitude'];
                        //     $newcustomer->longitude = $customer['longitude'];
                        //     $newcustomer->head = $customer['head'];
                        //     $newcustomer->barangay_id = $customer['barangay_id'];
                        //     $newcustomer->address = $customer['address'];
                        //     $newcustomer->tel = $customer['tel'];
                        //     $newcustomer->fax = $customer['fax'];
                        //     $newcustomer->email = $customer['email'];
                        //     $newcustomer->customer_type_id = $customer['customer_type_id'];
                        //     $newcustomer->business_nature_id = $customer['business_nature_id'];
                        //     $newcustomer->industrytype_id = $customer['industrytype_id'];
                        //     $newcustomer->created_at = $customer['created_at'];
                        //     $newcustomer->customer_old_id = $customer['customer_id'];
                        //     $newcustomer->Oldcolumn_municipalitycity_id = $customer['Oldcolumn_municipalitycity_id'];
                        //     $newcustomer->Oldcolumn_district = $customer['Oldcolumn_district'];
                        //     $newcustomer->local_customer_id = $customer['local_customer_id'];
                        //     $newcustomer->is_sync_up = $customer['is_sync_up'];
                        //     $newcustomer->is_updated = $customer['is_updated'];
                        //     $newcustomer->is_deleted = $customer['is_deleted'];
                        //     $newcustomer->save(false);
                        // }
            //             }    
            //   }    

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
    <?php $form = ActiveForm::begin(); ?>
   
        <div>
            <?php 
          echo   $sampletype = "<div class='row'><div class='col-md-2'  style='margin-left:15px'>".$form->field($model,'month')->widget(Select2::classname(),[
                            'data' => $month,
                            'id'=>'month',
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => ['id'=>'month'],
                            'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Month'],
                    ])->label("Month")."</div>"."<div class='col-md-2'>".$form->field($model,'year')->widget(Select2::classname(),[
                        'data' => $year,
                        'id'=>'year',
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['id'=>'year'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Year'],
                ])->label("Year")
               // ."</div>"."<div class='col-md-4' style='margin-top:4px'><br><span class='btn btn-success' id='offer' onclick='restore()'>BY YEAR</span>&nbsp;&nbsp;&nbsp;<span class='btn btn-success' id='offer' onclick='restorebyyear()'>BY MONTH</span>&nbsp;&nbsp;&nbsp;<span class='btn btn-success' id='sync' onclick='restore_sync  ()'>SYNC</span>";
                ."</div>"."<div class='col-md-4' style='margin-top:4px'><br><span class='btn btn-success' id='offer' onclick='restore()'>2013</span>&nbsp;&nbsp;&nbsp;<span class='btn btn-success' id='offer' onclick='restorebyyear()'>2014</span>&nbsp;&nbsp;&nbsp;<span class='btn btn-success' id='sync' onclick='restore_sync  ()'>SYNC</span>";
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
  
    <div class = "row" style="padding-left:15px;padding-right:15px" id="methodreference">
  
    <?= 
    GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'testname-grid',
        'pjax' => true,
    
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
              //  'before'=> "<b>No. of Customers: </b>".number_format($customer)."/ ".number_format($data_customer)."<br>"."<b>No. of Requests: </b>  ".number_format($request)."/ ".number_format($data)."<b><br>No. of Analyses:</b>".number_format($analysis)."/".number_format($data_analysis)."<b><br>No. of Sample: </b>".number_format($sample)."/".number_format($data_sample),
               'after'=>false,
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],     
            'activity',
            'date',
            'customer',
            'data',
            'month',
            'year',
            [
                'header'=>'Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                          return "<span class='badge btn-success' style='width:90px;height:20px'>COMPLETED</span>";            
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
                // 'pageSummary' => 'Total',
                // 'pageSummary' => true,               
            ],
        ],
    ]);
    ?>
</div>

<script type="text/javascript">
    $('#sample-test_id').on('change',function(e) {
       e.preventDefault();
         jQuery.ajax( {
            type: 'GET',
            url: '/lab/services/getmethod?id='+$(this).val(),
            dataType: 'html',
            data: { lab_id: $('#lab_id').val(), sample_type_id: $('#sample-sample_type_id').val()},
            success: function ( response ) {         
              $("#methodreference").html(response);
            },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
    });

    function restore(){

        var m = $('#month option:selected').text();
        var y = $('#year option:selected').text();
        
        $.ajax({
            url: "/api/lab/res",
            method: "POST",
            dataType: 'json',
            data: {month:m, year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( data ) {
                alert(data.message);
                $("#testname-grid").yiiGridView("applyFilter"); 

                $('.image-loader').removeClass("img-loader");
            });
        }

        function restorebyyear(){

        var m = $('#month option:selected').text();
        var y = $('#year option:selected').text();
        
        $.ajax({
            url: "/api/lab/resyear",
            method: "POST",
            dataType: 'json',
            data: {month:m, year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( data ) {
                alert(data.message);
                $("#testname-grid").yiiGridView("applyFilter"); 

                $('.image-loader').removeClass("img-loader");
            });
        }

        function restore_sync(){

        var m = $('#month option:selected').text();
        var y = $('#year option:selected').text();
        
        $.ajax({
            url: "/api/lab/ressync",
            method: "POST",
            dataType: 'json',
            data: {month:m, year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( data ) {
                alert(data.message);
                $("#testname-grid").yiiGridView("applyFilter"); 

                $('.image-loader').removeClass("img-loader");
            });
        }
</script>


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