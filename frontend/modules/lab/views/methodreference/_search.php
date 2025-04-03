<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\MethodreferenceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="methodreference-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'method_reference_id') ?>

    <?= $form->field($model, 'testname_id') ?>

    <?= $form->field($model, 'method') ?>

    <?= $form->field($model, 'reference') ?>

    <?= $form->field($model, 'fee') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
