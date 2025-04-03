<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\finance\Orcategory;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Orseries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orseries-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
         <div class="col-sm-12">
        <?php 

           echo $form->field($model, 'or_category_id')->widget(Select2::classname(), [
           'data' => ArrayHelper::map(Orcategory::find()->all(), 'or_category_id', 'category'),
           'theme' => Select2::THEME_BOOTSTRAP,
           'options' => ['placeholder' => 'Select Category'],
           'pluginOptions' => [
             'allowClear' => true
           ],
           ]);
        ?>
         </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <?= $form->field($model, 'or_series_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
        <?= $form->field($model, 'startor')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
        <?= $form->field($model, 'nextor')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
        <?= $form->field($model, 'endor')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id'=>'createor']) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
