<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\TestreportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testreport-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'testreport_id') ?>

    <?= $form->field($model, 'request_id') ?>

    <?= $form->field($model, 'lab_id') ?>

    <?= $form->field($model, 'report_num') ?>

    <?= $form->field($model, 'report_date') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'release_date') ?>

    <?php // echo $form->field($model, 'reissue') ?>

    <?php // echo $form->field($model, 'previous_id') ?>

    <?php // echo $form->field($model, 'new_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
