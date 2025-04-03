<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\DocumentcontrolSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documentcontrol-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'documentcontrol_id') ?>

    <?= $form->field($model, 'originator') ?>

    <?= $form->field($model, 'date_requested') ?>

    <?= $form->field($model, 'division') ?>

    <?= $form->field($model, 'code_num') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'previous_rev_num') ?>

    <?php // echo $form->field($model, 'new_revision_no') ?>

    <?php // echo $form->field($model, 'pages_revised') ?>

    <?php // echo $form->field($model, 'effective_date') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'reviewed_by') ?>

    <?php // echo $form->field($model, 'approved_by') ?>

    <?php // echo $form->field($model, 'dcf_no') ?>

    <?php // echo $form->field($model, 'custodian') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
