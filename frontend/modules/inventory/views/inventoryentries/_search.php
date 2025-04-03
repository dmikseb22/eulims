<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\InventoryEntriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-entries-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'inventory_transactions_id') ?>

    <?= $form->field($model, 'transaction_type_id') ?>

    <?= $form->field($model, 'rstl_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'manufacturing_date') ?>

    <?php // echo $form->field($model, 'expiration_date') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'suppliers_id') ?>

    <?php // echo $form->field($model, 'po_number') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'total_amount') ?>

    <?php // echo $form->field($model, 'Image1') ?>

    <?php // echo $form->field($model, 'Image2') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
