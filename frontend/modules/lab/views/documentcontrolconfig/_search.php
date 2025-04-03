<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\DocumentcontrolconfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documentcontrolconfig-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'documentcontrolconfig_id') ?>

    <?= $form->field($model, 'dcf') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'custodian') ?>

    <?= $form->field($model, 'approved') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
