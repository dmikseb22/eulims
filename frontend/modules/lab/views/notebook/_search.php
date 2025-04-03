<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\LabNotebookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lab-notebook-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'notebook_id') ?>

    <?= $form->field($model, 'notebook_name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'date_created') ?>

    <?= $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
