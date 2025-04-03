<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Bid */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bid-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'referral_id')->textInput() ?>

    <?= $form->field($model, 'bidder_agency_id')->textInput() ?>

    <?= $form->field($model, 'sample_requirements')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'bid_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estimated_due')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
