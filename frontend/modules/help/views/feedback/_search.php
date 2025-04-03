<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\feedback\UserFeedbackSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-feedback-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'feedback_id') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'urlpath_screen') ?>

    <?= $form->field($model, 'details') ?>

    <?= $form->field($model, 'steps') ?>

    <?php // echo $form->field($model, 'reported_by') ?>

    <?php // echo $form->field($model, 'region_reported') ?>

    <?php // echo $form->field($model, 'action_taken') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
