<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\ProcedureSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedure-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'procedure_id') ?>

    <?= $form->field($model, 'procedure_name') ?>

    <?= $form->field($model, 'procedure_code') ?>

    <?= $form->field($model, 'testname_id') ?>

    <?= $form->field($model, 'testname_method_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
