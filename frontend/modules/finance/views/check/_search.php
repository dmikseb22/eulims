<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\finance\CheckSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="check-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'check_id') ?>

    <?= $form->field($model, 'receipt_id') ?>

    <?= $form->field($model, 'bank') ?>

    <?= $form->field($model, 'checknumber') ?>

    <?= $form->field($model, 'checkdate') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
