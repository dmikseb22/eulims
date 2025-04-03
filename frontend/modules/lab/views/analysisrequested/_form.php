<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysisrequested */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="analysisrequested-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'analysis_id')->textInput() ?>

    <?= $form->field($model, 'sample_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'control_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'analysis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'joborder_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div> 