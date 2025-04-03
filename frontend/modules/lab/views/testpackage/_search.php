<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\TestpackageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testpackage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'testpackage_id') ?>

    <?= $form->field($model, 'lab_sampletype_id') ?>

    <?= $form->field($model, 'package_rate') ?>

    <?= $form->field($model, 'testname_methods') ?>

    <?= $form->field($model, 'added_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
