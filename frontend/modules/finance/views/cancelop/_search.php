<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\CancelledrequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cancelledrequest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'canceledrequest_id') ?>

    <?= $form->field($model, 'request_id') ?>

    <?= $form->field($model, 'request_ref_num') ?>

    <?= $form->field($model, 'reason') ?>

    <?= $form->field($model, 'cancel_date') ?>

    <?php // echo $form->field($model, 'cancelledby') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
