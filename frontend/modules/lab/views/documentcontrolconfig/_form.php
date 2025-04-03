<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrolconfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documentcontrolconfig-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dcf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custodian')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'approved')->textInput(['maxlength' => true]) ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
