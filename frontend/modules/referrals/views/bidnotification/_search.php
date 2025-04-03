<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\BidnotificationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bidnotification-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bid_notification_id') ?>

    <?= $form->field($model, 'referral_id') ?>

    <?= $form->field($model, 'postedby_agency_id') ?>

    <?= $form->field($model, 'posted_at') ?>

    <?= $form->field($model, 'recipient_agency_id') ?>

    <?php // echo $form->field($model, 'seen') ?>

    <?php // echo $form->field($model, 'seen_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
