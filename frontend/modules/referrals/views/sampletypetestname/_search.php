<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\SampletypetestnameSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sampletypetestname-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'sampletypetestname_id') ?>

    <?= $form->field($model, 'sampletype_id') ?>

    <?= $form->field($model, 'testname_id') ?>

    <?= $form->field($model, 'added_by') ?>

    <?= $form->field($model, 'date_added') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
