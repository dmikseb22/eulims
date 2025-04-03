<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\finance\Op;
use common\models\system\Profile;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Cancelledrequest */
/* @var $form yii\widgets\ActiveForm */
$disabled=false;
$Op=  Op::find()->where(['orderofpayment_id'=>$op_id])->one();
$model->transactionnum=$Op->transactionnum;
$model->orderofpayment_id=$Op->orderofpayment_id;
$model->cancelledby= Yii::$app->user->id;
// Query Profile Name
$Profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
$UserCancell=$Profile->fullname;
?>

<div class="cancelledrequest-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'orderofpayment_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'cancelledby')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'transactionnum')->textInput(['maxlength' => true,'readonly'=>true])->label("Transaction #") ?>

    <?= $form->field($model, 'cancel_date')->textInput(['readonly'=>true])->label('Date') ?>
    
    <?= $form->field($model, 'reason')->textarea(['style'=>'overflow-y: scroll']) ?>
    <label class="control-label" for="Cancelled By">Cancelled By:</label>                     
    <?= Html::tag('text',$UserCancell,['class'=>'form-control','readonly'=>true]) ?>
    <div class="row" style="float: right;padding-right: 15px;padding-top: 10px;margin-bottom: 10px">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['disabled'=>$disabled,'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if($model->isNewRecord){ ?>
        <?= Html::resetButton('Reset', ['disabled'=>$disabled,'class' => 'btn btn-danger']) ?>
        <?php } ?>
        <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
    <br>
    <?php ActiveForm::end(); ?>
</div>
