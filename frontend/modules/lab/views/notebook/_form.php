<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\LabNotebook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lab-notebook-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'notebook_name')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group pull-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
