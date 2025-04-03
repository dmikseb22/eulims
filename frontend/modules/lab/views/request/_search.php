<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\RequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'request_id') ?>

    <?= $form->field($model, 'request_ref_num') ?>

    <?= $form->field($model, 'request_datetime') ?>

    <?= $form->field($model, 'rstl_id') ?>

    <?= $form->field($model, 'lab_id') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <?php // echo $form->field($model, 'payment_type_id') ?>

    <?php // echo $form->field($model, 'modeofrelease_id') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'discount_id') ?>

    <?php // echo $form->field($model, 'purpose_id') ?>

    <?php // echo $form->field($model, 'or_id') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'report_due') ?>

    <?php // echo $form->field($model, 'conforme') ?>

    <?php // echo $form->field($model, 'receivedBy') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'posted') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
