<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\IssuancewithdrawalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issuancewithdrawal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'issuancewithdrawal_id') ?>

    <?= $form->field($model, 'document_code') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'rev_no') ?>

    <?= $form->field($model, 'copy_holder') ?>

    <?php // echo $form->field($model, 'copy_no') ?>

    <?php // echo $form->field($model, 'issuance') ?>

    <?php // echo $form->field($model, 'withdrawal') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
