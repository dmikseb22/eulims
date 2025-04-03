<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Attachment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attachment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'filetype')->textInput() ?>

    <?= $form->field($model, 'referral_id')->textInput() ?>

    <?= $form->field($model, 'upload_date')->textInput() ?>

    <?= $form->field($model, 'upload_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
