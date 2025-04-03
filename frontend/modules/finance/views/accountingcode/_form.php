<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Accountingcode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accountingcode-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'accountcode')->textInput(['maxlength' => true])->label('Account Code : ') ?>

    <?= $form->field($model, 'accountdesc')->textInput(['maxlength' => true])->label('Account Desc : ') ?>
    
     

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
