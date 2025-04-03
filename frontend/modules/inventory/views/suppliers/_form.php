<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\Suppliers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="suppliers-form">

    <?php $form = ActiveForm::begin(); ?>
     
    <?= $form->field($model, 'suppliers')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'fax_number')->textInput(['maxlength' => true]) ?>
        </div>    
    </div>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group pull-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
         <?php if(Yii::$app->request->isAjax){ ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
