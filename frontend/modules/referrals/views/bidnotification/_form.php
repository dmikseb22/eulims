<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Bidnotification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bidnotification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'referral_id')->textInput() ?>

    <?= $form->field($model, 'postedby_agency_id')->textInput() ?>

    <?= $form->field($model, 'posted_at')->textInput() ?>

    <?= $form->field($model, 'recipient_agency_id')->textInput() ?>

    <?= $form->field($model, 'seen')->textInput() ?>

    <?= $form->field($model, 'seen_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
