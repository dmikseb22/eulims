<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\api\YiiMigration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yii-migration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tblname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num')->textInput(['maxlength' => true]) ?>
    <div class="form-group pull-right">
             <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?php if(Yii::$app->request->isAjax){ ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
