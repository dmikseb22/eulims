<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\system\BackupConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="backup-config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mysqldump_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Description')->textarea(['rows' => 6]) ?>

    <div class="row pull-right" style="padding-right: 15px">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button style='margin-left: 5px' type='button' class='btn btn-secondary pull-left-sm' data-dismiss='modal'>Cancel</button>
    </div>  
    <?php ActiveForm::end(); ?>

</div>
