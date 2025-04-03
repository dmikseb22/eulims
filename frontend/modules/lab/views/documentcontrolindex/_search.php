<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\DocumentcontrolindexSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documentcontrolindex-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'documentcontrolindex_id') ?>

    <?= $form->field($model, 'dcf_no') ?>

    <?= $form->field($model, 'document_code') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'rev_no') ?>

    <?php // echo $form->field($model, 'effectivity_date') ?>

    <?php // echo $form->field($model, 'dc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
