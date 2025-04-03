<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Functions;
use kartik\money\MaskMoney;
use kartik\date\DatePicker;
use common\models\finance\Op;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Billing */
/* @var $form yii\widgets\ActiveForm */
$func=new Functions();
?>

<div class="billing-form" style="padding-top: 0px;margin-top: 0px">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'soa_number')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'billing_date')->hiddenInput()->label(false) ?>
    <?php if($model->isNewRecord){ ?>
    <?= $form->field($model, 'OpIds')->hiddenInput()->label(false) ?>
    <?php } ?>
     <div class="row">
        <div class="col-md-6">
           <label class="control-label" for="billing-invoice_number">Invoice Date</label>
        <?php 
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'billing_date',
                'readonly'=>true,
                //'disabled'=>true,
                'options' => ['placeholder' => 'Select Date'],
                'value'=>function($model){
                     return date("m/d/Y",$model->billing_date);
                },
                'pluginOptions' => [
                    'autoclose' => false,
                    'removeButton' => false,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); 
        ?>
        </div>
        <div class="col-md-6">
            <label class="control-label" for="billing-invoice_number">Due Date</label>
        <?php 
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'due_date',
                'readonly'=>true,
                //'disabled'=>true,
                'options' => ['placeholder' => 'Select Date'],
                'value'=>function($model){
                     return date("m/d/Y",$model->due_date);
                },
                'pluginOptions' => [
                    'autoclose' => false,
                    'removeButton' => false,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); 
        ?>
        </div>
    </div>
    <div class="row" style="padding-top: 0px;margin-top: 0px">
        <div class="col-md-6">
         <?= $form->field($model, 'invoice_number')->textInput(['readonly'=>true]) ?>
        </div>
        <div class="col-md-6">
        <label class="control-label" for="billing-invoice_number">Customer</label>
        <?php 
        echo $func->GetCustomerList($form, $model);
        ?>
        </div>
    </div>
   
    <hr style="margin-bottom: 10px;margin-top: 10px">
    <div class="row">
        <div id="OPGridContainer" class="col-md-12">
           <?php
                echo $this->renderAjax('_opgrid', [
                    'dataProvider' => $dataProvider,
                ]);
           ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            
        </div>
        <div class="col-md-4">
    <?php
    echo $form->field($model, 'amount')->widget(MaskMoney::classname(), [
         'readonly'=>true,
         'options'=>[
             'style'=>'text-align: right'
         ],
         'pluginOptions' => [
            'prefix' => '₱ ',
            'allowNegative' => false,
         ]
        ])->label(false);
    ?>
        </div>
    </div>
   <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id'=>'btnCreateBI','disabled'=>false]) ?>
            <button type="reset" class="btn btn-danger">Reset</button>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
