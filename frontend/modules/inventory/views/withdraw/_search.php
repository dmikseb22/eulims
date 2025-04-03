<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\InventoryWithdrawalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-withdrawal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'inventory_withdrawal_id') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'withdrawal_datetime') ?>

    <?= $form->field($model, 'lab_id') ?>

    <?= $form->field($model, 'total_qty') ?>

    <?php // echo $form->field($model, 'total_cost') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'inventory_status_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
