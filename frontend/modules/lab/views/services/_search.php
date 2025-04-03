quest<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\ServicesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'services_id') ?>

    <?= $form->field($model, 'rstl_id') ?>

    <?= $form->field($model, 'method_reference_id') ?>

    <?= $form->field($model, 'sampletype_id') ?>

    <?= $form->field($model, 'testname_method_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
