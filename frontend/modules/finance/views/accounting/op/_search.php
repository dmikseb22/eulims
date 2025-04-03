<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\finance\OpSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orderofpayment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'orderofpayment_id') ?>

    <?= $form->field($model, 'rstl_id') ?>

    <?= $form->field($model, 'transactionnum') ?>

    <?= $form->field($model, 'collectiontype_id') ?>

    <?= $form->field($model, 'order_date') ?>

    <?php  echo $form->field($model, 'customer_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
