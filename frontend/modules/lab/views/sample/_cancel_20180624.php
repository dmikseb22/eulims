<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sample */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    if($model->active != 0){
        $samplecancelled = 0;
    } else {
        $samplecancelled = 1;
    }
?>

<div class="sample-form">
    <div class="alert alert-danger">
        <?php
            if($samplecancelled == 0)
            {
                echo "Warning: If this sample contains analyses, the analyses will be cancelled too.";
            } else {
                echo "Note: Sample is already cancelled.";
            }
        ?>
    </div>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-error alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    <div style="margin:20px;">
        <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>
        <div class="row">
            <?= $form->field($model, 'sample_code')->textInput(['disabled' => true,'value'=>$model->sample_code]) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'samplename')->textInput(['disabled' => true,'value'=>$model->samplename]) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'description')->textInput(['disabled' => true]) ?>
        </div>
        <div class="row required">
            <?php if($samplecancelled == 0): ?>
                <?= $form->field($model, 'remarks')->textarea(['rows' => 6,'required' => true]) ?>
            <div class="help-block sample_remarks"></div>
            <?php else: ?>
                <?= $form->field($model, 'remarks')->textarea(['rows' => 6,'disabled' => true]) ?>
            <?php endif; ?>
        </div>
        <div class="form-group" style="padding-bottom: 3px;">
            <div style="float:right;">
                <?php if($samplecancelled == 0): ?>
                <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?php endif; ?>
                <?= Html::button('Close', ['class' => 'btn', 'onclick'=>'closeDialog()']) ?>
                <br>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">
function closeDialog(){
    $(".modal").modal('hide');
}
//$("#sample-remarks").focus(function(){
$('#sample-remarks').on('keyup keypress blur', function() {
   //if ($('#sample-remarks').val() == '') {
    if ($.trim($('#sample-remarks').val()).length < 1) {
        $('.sample_remarks').html("Remarks cannot be blank.");
        //$('.field-sample-remarks').css('color', '#FF0000');
        //$('#sample-remarks').css('border', '1px solid #FF0000');
        $(".field-sample-remarks").removeClass('has-success');
        $(".field-sample-remarks").addClass('has-error');
    }
    else {
        //$('#sample-remarks').css('border', '1px solid #00FF00');
        //$('.field-sample-remarks').css('color', '#00FF00');
        $('.sample_remarks').html("");
        $(".field-sample-remarks").removeClass('has-error');
        //$(".field-sample-remarks").addClass('has-success');
    }
    //if ($('#sample-remarks').val() == '') {
    /*if ($.trim($('#sample-remarks').val()).length < 1) {
        $('.help-block remarks').html("Remarks cannot be blank.");
        $(".form-group field-sample-remarks").removeClass('has-success');
        $(".form-group field-sample-remarks").addClass('has-error');
    } else {
        $(".form-group field-sample-remarks").removeClass('has-error');
        $(".form-group field-sample-remarks").addClass('has-success');
        $('.help-block remarks').html("Remarks cannot be blank.");
    }*/
});
</script>