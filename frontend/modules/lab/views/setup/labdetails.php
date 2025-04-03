<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sampletypetestname */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sampletypetestname-form">

    <?php $form = ActiveForm::begin(); ?>
  
    <!-- 'id' => 'ID',
            'rstl_id' => 'Rstl ID',
            'name' => 'Name',
            'address' => 'Address',
            'contacts' => 'Contacts',
            'shortName' => 'Short Name',
            'labName' => 'Lab Name',
            'labtypeShort' => 'Labtype Short',
            'description' => 'Description',
            'website' => 'Website', -->

    <?= $form->field($model, 'rstl_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'address')->textInput() ?>

    <?= $form->field($model, 'contacts')->textInput() ?>

    <?= $form->field($model, 'shortName')->textInput() ?>

    <?= $form->field($model, 'labName')->textInput() ?>

    <?= $form->field($model, 'labtypeShort')->textInput() ?>

    <?= $form->field($model, 'description')->textInput() ?>

    <?= $form->field($model, 'website')->textInput() ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
