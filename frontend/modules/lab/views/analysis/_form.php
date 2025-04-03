<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;
use yii\helpers\ArrayHelper;

use common\models\lab\Lab;
use common\models\lab\Testcategory;
use common\models\lab\Labsampletype;
use common\models\lab\Sampletype;
use common\models\lab\Request;
use common\models\lab\Sampletypetestname;
use common\models\lab\Testnamemethod;
use common\models\lab\Methodreference;
use common\models\lab\Testname;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="analysis-form">

  <div class="alert alert-danger" style="background: #ffc0cb !important;margin-top: 1px !important;">
   <a href="#" class="close" data-dismiss="alert" >×</a>
  <p class="note" style="color:#d73925"><b>Always check if you have chosen the right Laboratory in this Request: </b><br/> Test Methods won't load if it is meant for other Laboratory.</p>
   
  </div>

  <div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
   <a href="#" class="close" data-dismiss="alert" >×</a>
  <p class="note" style="color:#265e8d"><b>Note:</b> Please contact the Administrator or the Lab-Manager if the Test that you're looking for cannot be found.</p>
   
  </div>
    <?php $form = ActiveForm::begin(); ?>
 
    <?php
    if(!$model->isNewRecord){
    ?>
    <script type="text/javascript">
       $(document).ready(function(){
           $(".select-on-check-all").click();
        });
    </script>
    <?php
    
    }
?>
<div class="row">
  <div class="col-sm-12">

      <?php echo Html::activeLabel($model,'sample'); ?>
      <?= Select2::widget([
          'name' => 'base_samples',
          'data' => ArrayHelper::map($base_sample,'sample_id','samplename'),
          'options' => [
            'multiple' => true,
            'placeholder' => 'Select sample ...',
            'id'=>'base-sample',
            'tags'=>true
          ]
      ]);?>
 

  </div>
</div>

  <div class="row">
    <div class="col-sm-6">
      <?php echo Html::label('Sample Type'); ?>
      <?= Select2::widget([
          'name'=>'thesampletypes',
          'data' => $sampletypewithlab,
          'options' => [
            'placeholder' => 'Select sample type...',
            'id'=>'the-sample-type',
          ]
      ]);?>



    </div>
    <div class="col-sm-6" id="testname">

      <?= $form->field($model, 'test_id')->widget(DepDrop::classname(), [
            'type'=>DepDrop::TYPE_SELECT2,
            'data'=>$sampletype,
            'options'=>['id'=>'sample-sample_type_id'],
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['the-sample-type'],
                'placeholder'=>'Select Test Name',
                'url'=>Url::to(['/lab/analysis/listsampletype']),
                'loadingText' => 'Loading Test Names...',
            ]
        ])
        ?>
    </div>
  </div>
    <?= $form->field($model, 'rstl_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'pstcanalysis_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'request_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'sample_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'sample_code')->hiddenInput(['maxlength' => true])->label(false)?>

    <?= $form->field($model, 'testname')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'cancelled')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'is_package')->hiddenInput()->label(false)  ?>

    <?= $form->field($model, 'method')->hiddenInput()->label(false)  ?>
    <?= $form->field($model, 'references')->hiddenInput()->label(false)  ?>
    <?= $form->field($model, 'fee')->hiddenInput()->label(false)  ?>

    <?= Html::textInput('sample_ids', '', ['class' => 'form-control', 'id'=>'sample_ids','type'=>'hidden'], ['readonly' => true]) ?>
  
    <?php
        $requestquery = Request::find()->where(['request_id' => $request_id])->one();
    ?>

    <?= Html::textInput('lab_id', $requestquery->lab_id, ['class' => 'form-control', 'id'=>'lab_id', 'type'=>'hidden'], ['readonly' => true]) ?>
     
    <div id="methodreference">
    </div>       

    <div class="row-fluid" id ="xyz">
    </div>


    <div class="row" style="float: right;padding-right: 30px">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'analysis_create','disabled'=>true]) ?>
        <?php if($model->isNewRecord){ ?>
        <?php } ?>
    <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>

   

    </div>

    <?php ActiveForm::end(); ?>
</div>

    <script type="text/javascript">
    $('#sample-sample_type_id').on('change',function() {
        $.ajax({
            url: '/lab/analysis/gettestnamemethod',
            method: "GET",
            dataType: 'html',
            data: { sample: $('#base-sample').val(),
            sampletype_id: $('#the-sample-type').val(),
            testname_id: $(this).val()},
            beforeSend: function(xhr) {
               $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( response ) {
                $("#methodreference").html(response); 
                $('.image-loader').removeClass("img-loader");  
            });
    });




    $('#base-sample').on('change',function() {
        var samples = $(this).val();
        if(samples == '')
          $('#analysis_create').prop('disabled',true);
        else
          $('#analysis_create').prop('disabled',false);
    });


</script>
