<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Testnamemethod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testnamemethod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'testname_id')->textInput() ?>

    <?= $form->field($model, 'methodreference_id')->textInput() ?>

    <?= $form->field($model, 'added_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
