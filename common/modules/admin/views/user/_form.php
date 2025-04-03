<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\admin\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'password_hash')->passwordInput() ?>
    <div class="form-group">
        
    </div>
    <div class="form-group" style="float: right">
        <?php
        echo Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
        <button style='margin-left: 5px;' type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>
