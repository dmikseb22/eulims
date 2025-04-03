<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\message\ChatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'chat_id') ?>

    <?= $form->field($model, 'sender_userid') ?>

    <?= $form->field($model, 'chat_data') ?>

    <?= $form->field($model, 'timestamp') ?>

    <?= $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'group_id') ?>

    <?php // echo $form->field($model, 'contact_id') ?>

    <?php // echo $form->field($model, 'chat_data_type') ?>

    <?php // echo $form->field($model, 'message_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
