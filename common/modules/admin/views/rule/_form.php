<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */
/* @var $form ActiveForm */
?>

<div class="auth-item-form">
    <?php if(!Yii::$app->request->isAjax){ ?>
    <?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => 'rule']); ?>
    <?php } ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
    <?= $form->field($model, 'className')->textInput() ?>
    <div class="form-group" style="float: right">
        <?php
        echo Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        ?>
        <button style='margin-left: 5px;' type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>
