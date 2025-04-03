<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Packagelist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="packagelist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lab_id')->textInput() ?>

    <?= $form->field($model, 'sampletype_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_method')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
