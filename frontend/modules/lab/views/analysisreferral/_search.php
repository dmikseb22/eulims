<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\AnalysisreferralSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="analysis-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'analysis_id') ?>

    <?= $form->field($model, 'date_analysis') ?>

    <?= $form->field($model, 'rstl_id') ?>

    <?= $form->field($model, 'pstcanalysis_id') ?>

    <?= $form->field($model, 'request_id') ?>

    <?php // echo $form->field($model, 'sample_id') ?>

    <?php // echo $form->field($model, 'sample_code') ?>

    <?php // echo $form->field($model, 'testname') ?>

    <?php // echo $form->field($model, 'method') ?>

    <?php // echo $form->field($model, 'references') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'fee') ?>

    <?php // echo $form->field($model, 'test_id') ?>

    <?php // echo $form->field($model, 'testcategory_id') ?>

    <?php // echo $form->field($model, 'sample_type_id') ?>

    <?php // echo $form->field($model, 'cancelled') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'is_package') ?>

    <?php // echo $form->field($model, 'type_fee_id') ?>

    <?php // echo $form->field($model, 'old_sample_id') ?>

    <?php // echo $form->field($model, 'analysis_old_id') ?>

    <?php // echo $form->field($model, 'oldColumn_taggingId') ?>

    <?php // echo $form->field($model, 'oldColumn_result') ?>

    <?php // echo $form->field($model, 'oldColumn_package_count') ?>

    <?php // echo $form->field($model, 'oldColumn_requestId') ?>

    <?php // echo $form->field($model, 'oldColumn_deleted') ?>

    <?php // echo $form->field($model, 'methodreference_id') ?>

    <?php // echo $form->field($model, 'testname_id') ?>

    <?php // echo $form->field($model, 'old_request_id') ?>

    <?php // echo $form->field($model, 'local_analysis_id') ?>

    <?php // echo $form->field($model, 'local_sample_id') ?>

    <?php // echo $form->field($model, 'local_request_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
