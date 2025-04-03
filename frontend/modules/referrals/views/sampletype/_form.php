<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Sampletype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sampletype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sample_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_category_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
