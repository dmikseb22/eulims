<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;
use kartik\datetime\DateTimePicker;
use common\models\lab\Customer;
use yii\web\JsExpression;
use kartik\widgets\DatePicker;
use common\models\lab\Paymenttype;
use common\models\lab\Discount;
use common\models\lab\Modeofrelease;
use common\models\lab\Purpose;
use kartik\widgets\SwitchInput;
use common\components\Functions;
use yii\bootstrap\Modal;
use common\models\lab\RequestType;
use common\models\lab\Request;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\web\View;
use kartik\dialog\Dialog;

?>

<div class="request-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= $form->field($model, 'lab_id')->widget(Select2::classname(), [
                    'data' => $data->labs,
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select Laboratory'],
                    'pluginOptions'=>[
                       'placeholder'=>'Select Laboratory',
                       'LoadingText'=>'Loading...',
                       'allowClear' => true
                    ],
                ])->label('Laboratory'); ?>

                <div class="input-group">
                    <?php
                    $func = new Functions();
                    echo $func->GetCustomerList($form, $model,false,'Customer');
                    ?> 
                    <span class="input-group-btn" style="padding-top: 25.5px">
                        <button onclick="LoadModal('Create New Customer', '/customer/info/create');" class="btn btn-default" type="button"><i class="fa fa-user-plus"></i></button>
                    </span>
                </div>
                <?= $form->field($model, 'modeofreleaseId')->hiddenInput() ?>
                <?= $form->field($model, 'temp_modeofrelease')->widget(Select2::classname(), [
                    'data' =>$data->modesofrelease,
                    'language' => 'en',
                     'options' => [
                        'placeholder' => 'Select Mode of Release...',
                        'multiple' => true,
                    ],
                    'pluginEvents' => [
                        "change" => "function() { 
                            $('#referral-modeofreleaseid').val($(this).val());
                        }
                        ",
                    ]
                ])->label('Mode of Release'); ?> 

                <?= $form->field($model, 'discount_id')->widget(Select2::classname(), [
                    'data' => $data->discounts,
                    'language' => 'en',
                     'options' => [
                        'placeholder' => 'Discount Rates',
                    ],
                ])->label('Discount'); ?> 

                <?= $form->field($model, 'reason')->widget(Select2::classname(), [
                    'data' => $data->reasons,
                    'language' => 'en',
                     'options' => [
                        'placeholder' => 'Select one of the reason',
                    ],
                ])->label('Reason for Referring'); ?> 

                 <?= $form->field($model, 'purposeId')->widget(Select2::classname(), [
                    'data' => $data->purposes,
                    'language' => 'en',
                     'options' => [
                        'placeholder' => 'Select one of the purpose',
                    ],
                ])->label('Purpose'); ?> 
            </div>
        </div>

        <div class="col-md-6">
           
            <div class="form-group">
                <?= $form->field($model, 'referralDate')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Referral Date'],
                'value'=>function($model){
                     return date("m/d/Y",$model->referralDate);
                },
                   //'setOnEmpty' => true, 
                    'value' => '',
                'pluginOptions' => [
                        'autoclose' => true,
                        // 'setOnEmpty' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd'
                ],
                    'pluginEvents'=>[
                        "change" => "",
                    ]
                ])?>
                <?= $form->field($model, 'referralTime')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Enter Date'],
                'value'=>function($model){
                     return date("h:i P", strtotime($model->referralTime));
                },
                'convertFormat' => true,
            'pluginOptions' => [
                    'autoclose' => true,
                    'removeButton' => false,
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'format' => 'php:h:i P',
                    //'startDate'=>$RequestStartDate,
            ],
            ]); ?>

             <?= $form->field($model, 'samplereceivedDate')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Received Date'],
            'value'=>function($model){
                 return date("m/d/Y",$model->samplereceivedDate);
            },
               //'setOnEmpty' => true, 
                'value' => '',
            'pluginOptions' => [
                    'autoclose' => true,
                    // 'setOnEmpty' => true,
                    'removeButton' => false,
                    'format' => 'yyyy-mm-dd'
            ],
                'pluginEvents'=>[
                    "change" => "",
                ]
            ])?>

            <?= $form->field($model, 'reportDue')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Report Due'],
                'value'=>function($model){
                     return date("m/d/Y",$model->reportDue);
                },
                   //'setOnEmpty' => true, 
                    'value' => '',
                'pluginOptions' => [
                        'autoclose' => true,
                        // 'setOnEmpty' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd'
                ],
                    'pluginEvents'=>[
                        "change" => "",
                    ]
                ])?>

                 <?php echo $form->field($model, 'paymentType_id')->radioList(
                ['1'=>'PAID','2'=>'FULLY SUBSIDIZED']); ?>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
        <?= $form->field($model, 'conforme')->textInput() ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'receivedBy')->textInput(['readonly' => true]) ?>
        </div>
    </div>


    
    <div class="row" style="float: right;padding-right: 15px">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'btn-update']) ?>
        <?php if($model->isNewRecord){ ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-danger']) ?>
        <?php } ?>
        <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
