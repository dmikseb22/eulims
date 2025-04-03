<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\lab\Lab;
use common\models\lab\Fee;
use common\models\services\Testcategory;
use common\models\services\Sampletype;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;
use common\models\services\Test;
use kartik\money\MaskMoney;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Fee */
/* @var $form yii\widgets\ActiveForm */


$namelist= ArrayHelper::map(Fee::find()->all(),'fee_id', 'name');

$js=<<<SCRIPT
$(".kv-row-checkbox").click(function(){
   
   var keys = $('#sample-grid').yiiGridView('getSelectedRows');
   var keylist= keys.join();
   $("#sample_ids").val(keylist);
 
  $("#fee_btn").prop('disabled', keys=='');  
  
   
});    
$(".select-on-check-all").change(function(){

 var keys = $('#sample-grid').yiiGridView('getSelectedRows');
 var keylist= keys.join();
  $("#sample_ids").val(keylist);
 
  $("#fee_btn").prop('disabled', keys=='');  
  
 
});

$("#btnSaveRequest").click(function(){
    
});  

SCRIPT;

$jss=<<<SCRIPT

$("#total").val($("#fee-unit_cost").val()*$("#qty").val());

SCRIPT;



$this->registerJs($js);
?>

<div class="fee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= GridView::widget([
       'id' => 'sample-grid',
       'dataProvider'=> $sampleDataProvider,
       'pjax'=>true,
       'pjaxSettings' => [
           'options' => [
               'enablePushState' => false,
           ]
       ],
       'containerOptions'=>[
           'style'=>'overflow:auto; height:200px',
       ],
       'floatHeaderOptions' => ['scrollingTop' => true],
       'responsive'=>true,
       'striped'=>true,
       'hover'=>true,
       'bordered' => true,
       'panel' => [
          'heading'=>'<h3 class="panel-title">Samples</h3>',
          'type'=>'primary',
          'before' => '',
          'after'=>false,
       ],
       'toolbar' => false,
        'columns' => [
               [
            'class' => '\kartik\grid\CheckboxColumn',
         ],
            'samplename',
            [
                'attribute'=>'description',
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function($data){
                    return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".$data->sampling_date."</b></span>,&nbsp;".$data->description : $data->description;
                },
                'contentOptions' => ['style' => 'width:70%; white-space: normal;'],
            ],
        ],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">

        <?= $form->field($model, 'name')->widget(Select2::classname(), [
                        'data' => $namelist,
                        'language' => 'en',
                         'options' => ['placeholder' => 'Select Name', 'id'=>'fee_list'],
                         'pluginOptions' => [
                         'allowClear' => true

                        ],
                ])->label("Name"); ?>
        </div>
        <div class="col-sm-6">

        <?= Html::textInput('sample_ids', '', ['class' => 'form-control', 'id'=>'sample_ids', 'type'=>"hidden"], ['readonly' => true]) ?>
        <?php
        echo $form->field($model, 'unit_cost')->widget(MaskMoney::classname(), [
        'readonly'=>true,
        'options'=>[
            'style'=>'text-align: right'
        ],
        'pluginOptions' => [
           'prefix' => '₱ ',
           'allowNegative' => false,
        ]
       ])->label("Unit Cost");
    ?>

        </div>
    </div>

  
    
                        
    <div class="row" style="float: right;padding-right: 30px">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'fee_btn', 'disabled'=>true]) ?>
        <?php if($model->isNewRecord){ ?>
        <?php } ?>
    <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

  
</div>

<?php
// $this->registerJs("$('#fee_list').on('change',function(){
//     var id = $('#fee_list').val();
//         $.ajax({
//             url: '".Url::toRoute("fee/getlistfee")."',
//             dataType: 'json',
//             method: 'GET',
//             data: {fee_id: id},
//             success: function (data, textStatus, jqXHR) {
//                  $('.image-loader').removeClass( \"img-loader\" );
//                 alert('boom');
//             },
//             beforeSend: function (xhr) {
//                 alert('Please wait...');
//                 image-loader').addClass( \"img-loader\" );
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 console.log('An error occured!');
//                 alert('Error in ajax request');
//             }
//         });
// });");
?>

<?php
$this->registerJs("$('#fee_list').on('change',function(){
    var id = $('#fee_list').val();
        $.ajax({
            url: '".Url::toRoute("fee/getlistfee")."',
            dataType: 'json',
            method: 'GET',
            data: {fee_id: id},
            success: function (data, textStatus, jqXHR) {
                    $('#fee-unit_cost').val(data.unit_cost);
                    $('#fee-unit_cost-disp').val(data.unit_cost);
                $('.image-loader').removeClass( \"img-loader\" );
            },
            beforeSend: function (xhr) {
                //alert('Please wait...');
                $('.image-loader').addClass( \"img-loader\" );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('An error occured!');
                alert('Error in ajax request');
            }
        });
});");
?>
