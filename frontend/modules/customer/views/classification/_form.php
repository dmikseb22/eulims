<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Classification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="classification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'classification')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
