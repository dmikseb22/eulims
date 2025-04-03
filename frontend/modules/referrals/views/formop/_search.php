<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\FormopSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="formop-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'formop_id') ?>

    <?= $form->field($model, 'agency_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'rev_num') ?>

    <?php // echo $form->field($model, 'print_format') ?>

    <?php // echo $form->field($model, 'rev_date') ?>

    <?php // echo $form->field($model, 'logo_left') ?>

    <?php // echo $form->field($model, 'logo_right') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
