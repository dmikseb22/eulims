<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Check */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="check-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'receipt_id')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'checknumber')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <?php
             echo $form->field($model, 'checkdate')->widget(DatePicker::classname(), [
             'options' => ['placeholder' => 'Select Date ...',
             'autocomplete'=>'off'],
             'type' => DatePicker::TYPE_COMPONENT_APPEND,
                 'pluginOptions' => [
                     
                     'format' => 'yyyy-mm-dd',
                     'todayHighlight' => true,
                     'autoclose'=>true,   
                 ]
             ]);
        ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'amount')->textInput() ?>
        </div>
    </div>
    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id'=>'updateCheck',
            'disabled'=>false]) ?>
       <button type="reset" class="btn btn-danger">Reset</button>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>


    </div    <?php ActiveForm::end(); ?>

</div>
