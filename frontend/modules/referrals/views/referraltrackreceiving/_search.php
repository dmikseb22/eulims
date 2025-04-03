<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\ReferraltrackreceivingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="referraltrackreceiving-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'referraltrackreceiving_id') ?>

    <?= $form->field($model, 'referral_id') ?>

    <?= $form->field($model, 'receiving_agency_id') ?>

    <?= $form->field($model, 'testing_agency_id') ?>

    <?= $form->field($model, 'sample_received_date') ?>

    <?php // echo $form->field($model, 'courier_id') ?>

    <?php // echo $form->field($model, 'shipping_date') ?>

    <?php // echo $form->field($model, 'cal_specimen_received_date') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
