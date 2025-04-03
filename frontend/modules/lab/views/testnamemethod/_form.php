<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Testnamemethod */
/* @var $form yii\widgets\ActiveForm */

/*
Created By: Bergel T. Cutara
Contacts:

Email: b.cutara@gmail.com
Tel. Phone: (062) 991-1024
Mobile Phone: (639) 956200353

Description: All lookup table should meet here, a single interface to manage the labs, sampletypes, testnames and methods, please avoid querying in the view files as much as you can.
**/
?>



<div class="testnamemethod-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="input-group">
            <?= $form->field($model,'lab_id')->widget(Select2::classname(),[
                    'data' => $labs,
                    'id'=>'lab_id',
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id'=>'sample-lab_id'],
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Lab'],
            ])
            ?>
        </div>

        <div class="input-group">
            <?= $form->field($model,'sampletype_id')->widget(Select2::classname(),[
                    'data' => $sampletypes,
                    'id'=>'sampletype_id',
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id'=>'sample-sampletype_id'],
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Sample Type'],
            ])
            ?>
            <span class="input-group-btn" style="padding-top: 25.5px">
                <button onclick="LoadModal('Create New Sampletype', '/lab/sampletype/createbytestnamemethod');"class="btn btn-default" type="button"><i class="fa fa-plus"></i></button>
            </span> 
        </div>

        <div class="input-group">
            <?= $form->field($model,'testname_id')->widget(Select2::classname(),[
                    'data' => $testnamelist,
                    'id'=>'testname_id',
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id'=>'sample-testcategory_id'],
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Test Name'],
            ])
            ?>
            
            <span class="input-group-btn" style="padding-top: 25.5px">
                <button onclick="LoadModal('Create New Test Name', '/lab/testname/createbytestnamemethod');"class="btn btn-default" type="button"><i class="fa fa-plus"></i></button>
            </span>
        </div>

        <div class="input-group">
            <?= $form->field($model, 'method_id')->hiddenInput(['maxlength' => true])->label(false) ?>
        </div>

        <div id="methodreference">
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'create_time')->textInput(['readonly' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'update_time')->textInput(['readonly' => true]) ?>
            </div>
        </div>
        <div class="form-group pull-right">
            <button onclick="LoadModal('Create New Method Reference', '/lab/methodreference/createbytestnamemethod');"class="btn btn-warning" type="button"><i class="fa fa-plus"></i> Method Reference</button>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if(Yii::$app->request->isAjax){ ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <?php } ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    $('#sample-testcategory_id').on('change',function() {
        $.ajax({
            url: '/lab/testnamemethod/getmethod?id='+$(this).val(),
            method: "GET",
            dataType: 'html',
            data: { lab_id: 1,
            testname_id: $('#method_id').val()},
            beforeSend: function(xhr) {
               $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( response ) {
                $("#methodreference").html(response); 
                $('.image-loader').removeClass("img-loader");  
            });
    });
</script>
