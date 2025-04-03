<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrolindex */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documentcontrolindex-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dcf_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'document_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rev_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'effectivity_date')->textInput() ?>

    <?= $form->field($model, 'dc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
