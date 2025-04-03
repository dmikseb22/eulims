<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\InventoryWithdrawal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-withdrawal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'withdrawal_datetime')->textInput() ?>

    <?= $form->field($model, 'lab_id')->textInput() ?>

    <?= $form->field($model, 'total_qty')->textInput() ?>

    <?= $form->field($model, 'total_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'inventory_status_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
