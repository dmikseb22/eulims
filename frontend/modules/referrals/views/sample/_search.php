<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\SampleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sample-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'sample_id') ?>

    <?= $form->field($model, 'referral_id') ?>

    <?= $form->field($model, 'receiving_agency_id') ?>

    <?= $form->field($model, 'pstcsample_id') ?>

    <?= $form->field($model, 'package_id') ?>

    <?php // echo $form->field($model, 'package_fee') ?>

    <?php // echo $form->field($model, 'sample_type_id') ?>

    <?php // echo $form->field($model, 'sample_code') ?>

    <?php // echo $form->field($model, 'samplename') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'sampling_date') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'sample_month') ?>

    <?php // echo $form->field($model, 'sample_year') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
