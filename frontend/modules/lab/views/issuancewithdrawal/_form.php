<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use common\models\lab\Documentcontrol;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\lab\Issuancewithdrawal */
/* @var $form yii\widgets\ActiveForm */

$documentcontrol= ArrayHelper::map(Documentcontrol::find()->all(),'code_num','code_num');
?>

<div class="issuancewithdrawal-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
        <?= $form->field($model, 'document_code')->widget(Select2::classname(), [
                        'data' => $documentcontrol,
                        'language' => 'en',
                         'options' => ['placeholder' => 'Select Code', 'id'=>'doc_code'],
                         'pluginOptions' => [
                         'allowClear' => true

                        ],
                ])->label("Document Code"); ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'readonly'=>true,]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'rev_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
             <?= $form->field($model, 'copy_holder')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'copy_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'issuance')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'withdrawal')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
        <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'readonly'=>true,
                'options' => ['placeholder' => 'Enter Date'],
                'convertFormat' => true,
                 'pluginOptions' => [
                    'autoclose' => true,
                    'removeButton' => false,
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'format' => 'php:Y-m-d',
            ],             
            ])->label('Date'); ?>
        </div>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("$('#doc_code').on('change',function(){
    var id = $('#doc_code').val();
        $.ajax({
            url: '".Url::toRoute("documentcontrol/gettitle")."',
            dataType: 'json',
            method: 'GET',
            data: {code_num: id},
            success: function (data, textStatus, jqXHR) {
                
                 $('#issuancewithdrawal-title').val(data.title);
                 $('.image-loader').removeClass( \"img-loader\" );
            },
            beforeSend: function (xhr) {
                $('.image-loader').addClass( \"img-loader\" );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('An error occured!');
                alert('Error in ajax request');
            }
        });
});");
?>
