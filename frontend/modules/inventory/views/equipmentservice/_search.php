<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\EquipmentserviceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipmentservice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'equipmentservice_id') ?>

    <?= $form->field($model, 'inventory_transactions_id') ?>

    <?= $form->field($model, 'servicetype_id') ?>

    <?= $form->field($model, 'requested_by') ?>

    <?= $form->field($model, 'startdate') ?>

    <?php // echo $form->field($model, 'enddate') ?>

    <?php // echo $form->field($model, 'request_status') ?>

    <?php // echo $form->field($model, 'attachment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
