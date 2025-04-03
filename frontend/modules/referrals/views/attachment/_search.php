<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\AttachmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attachment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'attachment_id') ?>

    <?= $form->field($model, 'filename') ?>

    <?= $form->field($model, 'filetype') ?>

    <?= $form->field($model, 'referral_id') ?>

    <?= $form->field($model, 'upload_date') ?>

    <?php // echo $form->field($model, 'upload_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
