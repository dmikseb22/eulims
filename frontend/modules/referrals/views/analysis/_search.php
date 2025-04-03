<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\AnalysisSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="analysis-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'analysis_id') ?>

    <?= $form->field($model, 'analysis_type_id') ?>

    <?= $form->field($model, 'date_analysis') ?>

    <?= $form->field($model, 'agency_id') ?>

    <?= $form->field($model, 'pstcanalysis_id') ?>

    <?php // echo $form->field($model, 'sample_id') ?>

    <?php // echo $form->field($model, 'testname_id') ?>

    <?php // echo $form->field($model, 'methodreference_id') ?>

    <?php // echo $form->field($model, 'analysis_fee') ?>

    <?php // echo $form->field($model, 'cancelled') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
