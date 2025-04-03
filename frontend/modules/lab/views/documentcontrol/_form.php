<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use common\models\system\Profile;
use common\models\lab\Division;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrol */
/* @var $form yii\widgets\ActiveForm */

$profiles= ArrayHelper::map(Profile::find()->all(),'fullname','fullname');
$division= ArrayHelper::map(Division::find()->all(),'name','name');
?>

<div class="documentcontrol-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
        <?= $form->field($model,'originator')->widget(Select2::classname(),[
                    'data' => $profiles,
                    'theme' => Select2::THEME_KRAJEE,
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Name'],
            ])
    ?>
        </div>
        <div class="col-sm-6">
                <?= $form->field($model, 'date_requested')->widget(DatePicker::classname(), [
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
            ])->label('Date Requested'); ?>
        </div>
    </div>
    
    <div>
    <?= $form->field($model,'division')->widget(Select2::classname(),[
                    'data' => $division,
                    'theme' => Select2::THEME_KRAJEE,
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Division'],
            ])
    ?>
     
     <hr>
      
     </div>
    <?= $form->field($model, 'code_num')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?> 
    <hr>
        <!-- <div class="col-sm-6">
          
        </div>
    </div> -->

    <div class="row">
        <div class="col-sm-6">
             <?= $form->field($model, 'previous_rev_num')->textInput(['maxlength' => true]) ?>
          
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'new_revision_no')->textInput(['maxlength' => true]) ?>
           
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
        <?= $form->field($model, 'pages_revised')->textInput(['maxlength' => true]) ?>
       
        </div>
        <div class="col-sm-6">
        <?= $form->field($model, 'effective_date')->widget(DatePicker::classname(), [
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
            ])->label('Effective Date'); ?>
          
        </div>
    </div>
    <hr>
    <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <hr>
    <div class="row">
        <div class="col-sm-6">
        <?= $form->field($model, 'reviewed_by')->textInput(['maxlength' => true, 'readOnly'=> true]) ?>
        </div>
        <div class="col-sm-6">
        <?= $form->field($model, 'approved_by')->textInput(['maxlength' => true, 'readOnly'=> true]) ?>
        </div>
    </div>
   
    <div class="row">
        <div class="col-sm-6">
        <?php //$form->field($model, 'dcf_no')->textInput(['maxlength' => true]) ?>
       

        <?= $form->field($model, 'dcf_no')->textInput(['maxlength' => true, 'readOnly'=> true]) ?>

        </div>
        <div class="col-sm-6">
        <?= $form->field($model, 'custodian')->textInput(['maxlength' => true, 'readOnly'=> true]) ?>

        </div>
    </div>
  
   
    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
