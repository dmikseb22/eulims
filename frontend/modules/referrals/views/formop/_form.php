<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Formop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="formop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'agency_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rev_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'print_format')->textInput() ?>

    <?= $form->field($model, 'rev_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo_left')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo_right')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
