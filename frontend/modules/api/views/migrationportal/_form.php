<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\api\Migrationportal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="migrationportal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_migrated')->textInput() ?>

    <?= $form->field($model, 'record_id')->textInput() ?>

    <?= $form->field($model, 'table_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
