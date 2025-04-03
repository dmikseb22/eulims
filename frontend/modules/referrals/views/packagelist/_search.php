<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\PackagelistSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="packagelist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'package_id') ?>

    <?= $form->field($model, 'lab_id') ?>

    <?= $form->field($model, 'sampletype_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'test_method') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
