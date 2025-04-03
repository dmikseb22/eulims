<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\message\Chat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sender_userid')->textInput() ?>

    <?= $form->field($model, 'chat_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <?= $form->field($model, 'status_id')->textInput() ?>

    <?= $form->field($model, 'group_id')->textInput() ?>

    <?= $form->field($model, 'contact_id')->textInput() ?>

    <?= $form->field($model, 'chat_data_type')->textInput() ?>

    <?= $form->field($model, 'message_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
