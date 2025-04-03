<?php
use yii\helpers\Html;
use yii\bootstrap\Progress;
use kartik\grid\GridView;
use common\models\finance\Op;
use common\models\finance\Paymentitem;
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
$year = ['0000','1970','2013', '2014', '2015', '2016', '2017', '2018','2019'];
//$lablist= ArrayHelper::map( $decode,'lab_id','labname');
$this->title = 'Backup and Restore';
$this->params['breadcrumbs'][] = ['label' => 'API', 'url' => ['/api']];
$this->params['breadcrumbs'][] = $this->title;
//$op_button="<button type='button' value='/finance/cashier/view-receipt?receiptid=$model->receipt_id' id='Receipt2' style='float: right;margin-right: 5px' class='btn btn-success' onclick='location.href=this.value'><i class='fa fa-eye'></i> Op</button>";  
?>

<div class="services-index">
   
<fieldset>
    <legend>Legend/Status</legend>
    <div>
    <span class='badge btn-success legend-font' ><span class= 'glyphicon glyphicon-check'></span> DONE</span>
    <span class='badge btn-danger legend-font' ><span class= 'glyphicon glyphicon-check'></span> PENDING</span>

 
                
    </div>
</fieldset> 
    <div class="image-loader" style="display: hidden;"></div>
    <?php $form = ActiveForm::begin(); ?>
   
        <div>
            <?php 
          echo   $sampletype = "<div class='row'><div class='col-md-2'>".$form->field($model,'transaction_date')->widget(Select2::classname(),[
                        'data' => $year,
                        'id'=>'year',
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['id'=>'year'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Year'],
                ])->label("Year")."</div>"."<div class='col-md-10' style='margin-top:4px'><br><span class='btn btn-success' id='restore_paymentitem' onclick='restore_paymentitem()'>Paymentitem</span>"
                  . "&nbsp;&nbsp;&nbsp;<span class='btn btn-success' id='restore_sync' onclick='restoresync()'>Restore</span>&nbsp;&nbsp;&nbsp;<span class='btn btn-success' id='resync' onclick='resync()'>Re-Sync</span></div>";
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
  
    <div class = "row" style="padding-left:15px;padding-right:15px" id="finance">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'finance-grid',
        'pjax' => true,
      //  'showPageSummary' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> "<b>OP: </b>".$op."<b><br>Paymentitem:</b>".$paymentitem."<b><br>Receipt: </b>".$receipt."<b><br>Deposit: </b>".$deposit."<b><br>Check: </b>".$check,
                'after'=>false,
         ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],     
            'activity',
            'transaction_date',
            'data_date',
            'op',
            'paymentitem',
            'receipt',
            'check',
            'deposit',
            [
                'header'=>'Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                          return "<span class='badge btn-success' style='width:90px;height:20px'>COMPLETED</span>";            
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
                
            ],
        ],
    ]);
    
    ?>
  
</div>

<script type="text/javascript">
    function restore(){
        var y = $('#year option:selected').text();
    
        $.ajax({
            url: "/api/finance/res",
            method: "POST",
            data: {year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function(data) {
                $("#finance-grid").yiiGridView("applyFilter"); 
                $('.image-loader').removeClass("img-loader");
            });
        }
         function restoresync(){
        var y = $('#year option:selected').text();
    
        $.ajax({
            url: "/api/finance/ressync",
            method: "POST",
            data: {year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function(data) {
                $("#finance-grid").yiiGridView("applyFilter"); 
                $('.image-loader').removeClass("img-loader");
            });
        }
        function restore_receipt(){
        var y = $('#year option:selected').text();
        $.ajax({
            url: "/api/finance/res_receipt",
            method: "POST",
            data: {year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function(data) {
                $("#finance-grid").yiiGridView("applyFilter"); 
                $('.image-loader').removeClass("img-loader");
            });
        }
        function restore_paymentitem(){
        $.ajax({
            url: "/api/finance/res_paymentitem",
            method: "POST",
            data: {},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function(data) {
                $("#finance-grid").yiiGridView("applyFilter"); 
                $('.image-loader').removeClass("img-loader");
            });
        }
        
        function restore_deposit(){
        var y = $('#year option:selected').text();    
        $.ajax({
            url: "/api/finance/res_deposit",
            method: "POST",
            data: {year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function(data) {
                $("#finance-grid").yiiGridView("applyFilter"); 
                $('.image-loader').removeClass("img-loader");
            });
        }
        function resync(){
        var today = new Date();
        var y = today.getFullYear();  
  
        $.ajax({
            url: "/api/finance/syncagain",
            method: "POST",
            data: {year:y},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function(data) {
                $("#finance-grid").yiiGridView("applyFilter"); 
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