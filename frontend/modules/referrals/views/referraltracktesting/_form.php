<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Referraltracktesting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="referraltracktesting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'referral_id')->textInput() ?>

    <?= $form->field($model, 'testing_agency_id')->textInput() ?>

    <?= $form->field($model, 'receiving_agency_id')->textInput() ?>

    <?= $form->field($model, 'date_received_courier')->textInput() ?>

    <?= $form->field($model, 'analysis_started')->textInput() ?>

    <?= $form->field($model, 'analysis_completed')->textInput() ?>

    <?= $form->field($model, 'cal_specimen_send_date')->textInput() ?>

    <?= $form->field($model, 'courier_id')->textInput() ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
