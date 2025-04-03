<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\JoborderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="joborder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'joborder_id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'joborder_date') ?>

    <?= $form->field($model, 'sampling_date') ?>

    <?= $form->field($model, 'lsono') ?>

    <?php // echo $form->field($model, 'sample_received') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div> 