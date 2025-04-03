<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Lab */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lab-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lab_id')->textInput() ?>

    <?= $form->field($model, 'labname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'labcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
