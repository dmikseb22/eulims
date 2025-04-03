<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\components\Functions;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Op */
/* @var $form yii\widgets\ActiveForm */
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-item").each(function(index) {
        jQuery(this).html("Payment Item: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-item").each(function(index) {
        jQuery(this).html("Payment Item: " + (index + 1))
    });
});
';

$this->registerJs($js);
?>

<div class="orderofpayment-form" style="margin:0important;padding:0px!important;padding-bottom: 10px!important;">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="alert alert-info" style="background: #d9edf7 !important;margin-top: 1px !important;">
        <a href="#" class="close" data-dismiss="alert" >×</a>
        <p class="note" style="color:#265e8d">Fields with <i class="fa fa-asterisk text-danger"></i> are required.</p>
    </div>
   
    <div class="panel panel-default">
        <div class="panel-heading"><i class="glyphicon glyphicon-list"></i></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $paymentitem[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'details',
                    'amount',
                ],
            ]); ?>

            <div class="container-items">
            <?php foreach ($paymentitem as $index => $paymentitems): ?>
           
                <div class="item panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title-item">Payment Item: <?= ($index + 1) ?></span>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $paymentitems->isNewRecord) {
                                echo Html::activeHiddenInput($paymentitems, "[{$index}]paymentitem_id");
                            }
                        ?>
                       <div class="row">
                            <div class="col-sm-6">
                                 <?php echo $form->field($paymentitems, "[{$index}]details")->textInput(['value'=>''])->label('Details') ?>
                            </div>
                             <div class="col-sm-6">
                                <?php echo $form->field($paymentitems, "[{$index}]amount")->textInput()->label('Amount') ?>
                             </div>
                        </div>
                       
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group pull-right">
        <?= Html::submitButton($paymentitems->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
           <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<style>
    .modal-body{
        padding-top: 0px!important;
    }
</style>

<script type="text/javascript">
  $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
  console.log("beforeInsert");
    
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});
</script>
