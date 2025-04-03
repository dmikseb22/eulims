<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\AnlysisrequestedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="analysisrequested-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'analysis_id') ?>

    <?= $form->field($model, 'sample_description') ?>

    <?= $form->field($model, 'control_no') ?>

    <?= $form->field($model, 'analysis') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'joborder_id') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
