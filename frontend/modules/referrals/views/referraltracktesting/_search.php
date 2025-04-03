<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\ReferraltracktestingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="referraltracktesting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'referraltracktesting_id') ?>

    <?= $form->field($model, 'referral_id') ?>

    <?= $form->field($model, 'testing_agency_id') ?>

    <?= $form->field($model, 'receiving_agency_id') ?>

    <?= $form->field($model, 'date_received_courier') ?>

    <?php // echo $form->field($model, 'analysis_started') ?>

    <?php // echo $form->field($model, 'analysis_completed') ?>

    <?php // echo $form->field($model, 'cal_specimen_send_date') ?>

    <?php // echo $form->field($model, 'courier_id') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
