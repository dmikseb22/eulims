<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use rmrevin\yii\fontawesome\FA;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Package */
/* @var $form yii\widgets\ActiveForm */
$FontAwesomeList=FA::getConstants();

?>

<div class="package-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'PackageName')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?=
    $form->field($model, 'icon')->widget(Select2::classname(), [
        'data' => $ArrayIcons,
        'language' => 'en',
        'options' => ['placeholder' => 'Select Icon'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <div class="row pull-right" style="float: right;padding-right: 15px">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
