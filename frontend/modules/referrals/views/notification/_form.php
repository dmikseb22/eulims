<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Notification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'referral_id')->textInput() ?>

    <?= $form->field($model, 'notification_type_id')->textInput() ?>

    <?= $form->field($model, 'recipient_id')->textInput() ?>

    <?= $form->field($model, 'sender_id')->textInput() ?>

    <?= $form->field($model, 'sender_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seen')->textInput() ?>

    <?= $form->field($model, 'notification_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
