<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\finance\BankaccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bankaccount-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bankaccount_id') ?>

    <?= $form->field($model, 'bank_name') ?>

    <?= $form->field($model, 'account_number') ?>

    <?= $form->field($model, 'rstl_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
