<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\PackageofferSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="packageoffer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'packageoffer_id') ?>

    <?= $form->field($model, 'agency_id') ?>

    <?= $form->field($model, 'packagelist_id') ?>

    <?= $form->field($model, 'offered_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
