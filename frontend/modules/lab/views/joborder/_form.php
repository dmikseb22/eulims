<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\lab\Customer;
use kartik\widgets\DatePicker;
use common\models\lab\Lab;
use common\components\Functions;
use kartik\datetime\DateTimePicker;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
use common\models\lab\Testcategory;

$customerlist= ArrayHelper::map(Customer::find()->orderBy(['customer_id' => SORT_DESC])->all(),'customer_id','customer_name');
$lablist= ArrayHelper::map(Lab::find()->where(['active'=>1])->orderBy(['lab_id' => SORT_DESC])->all(),'lab_id','labname');


/* @var $this yii\web\View */
/* @var $model common\models\lab\Joborder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="joborder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'joborder_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'lsono')->hiddenInput()->label(false) ?>

    <?= $form->field($model,'lab')->widget(Select2::classname(),[
                    'data' => $lablist,
                    'theme' => Select2::THEME_KRAJEE,
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Lab'],
            ])->label("Lab")
    ?>

  
    <div class="input-group">
 <?= $form->field($model,'customer_id')->widget(Select2::classname(),[
                    'data' => $customerlist,
                    'theme' => Select2::THEME_KRAJEE,
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Customer'],
            ])->label("Client")
    ?>
      <span class="input-group-btn" style="padding-top: 25.5px">
                    <button onclick="LoadModal('Create New Test Category', '/lab/testcategory/createcategory');"class="btn btn-default" type="button"><i class="fa fa-plus"></i></button>
     </span>
    </div>
    <br>
  
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'telno')->textInput(['maxlength' => true]) ?>
   
    <!-- customer and address, tel no here -->
  
    <?= $form->field($model, 'joborder_date')->widget(DateTimePicker::classname(), [
        'readonly'=>true,
	    'options' => ['placeholder' => 'Enter Date'],
        'value'=>function($model){
             return date("m/d/Y h:i:s P", strtotime($model->joborder_date));
        },
        'convertFormat' => true,
    ])->label('Date'); ?>
    <?= $form->field($model, 'sampling_date')->textInput(['maxlength' => true]) ?>
  
     <?= $form->field($model, 'sample_received')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'conforme')->textInput(['maxlength' => true]) ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div> 