<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\finance\OrseriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orseries-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'or_series_id') ?>

    <?= $form->field($model, 'or_category_id') ?>

    <?= $form->field($model, 'terminal_id') ?>

    <?= $form->field($model, 'rstl_id') ?>

    <?= $form->field($model, 'or_series_name') ?>

    <?php // echo $form->field($model, 'startor') ?>

    <?php // echo $form->field($model, 'nextor') ?>

    <?php // echo $form->field($model, 'endor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
