<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\lab\Lab;
use common\models\services\Testcategory;
use common\models\services\Sampletype;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\Typeahead;
use common\models\services\Test;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Packagelist */
/* @var $form yii\widgets\ActiveForm */

$Testcategorylist= ArrayHelper::map(Testcategory::find()->all(),'testcategory_id','category_name');
$Sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sample_type_id','sample_type');


?>

<div class="packagelist-form" style="padding-bottom: 10px">

    <?php $form = ActiveForm::begin(); ?>

    

    <div class="row">
             <div class="col-md-6">
              
                 <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
             </div>

             <div class="col-md-6">
             <?php
            echo $form->field($model, 'rate')->widget(MaskMoney::classname(), [
            'readonly'=>true,
            'options'=>[
                'style'=>'text-align: right'
            ],
            'pluginOptions' => [
               'prefix' => '₱ ',
               'allowNegative' => false,
            ]
           ])->label("Rate");
        ?>
             
             </div>
         </div>

         <div class="row">
             <div class="col-md-6">
             <?= $form->field($model,'testcategory_id')->widget(Select2::classname(),[
                        'data' => $testcategory,
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => ['id'=>'sample-testcategory_id'],
                        'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Test category'],
                ])
            ?>
           
             </div>

             <div class="col-md-6">
             <?=
                     
                 $form->field($model, 'sample_type_id')->widget(DepDrop::classname(), [
                    'type'=>DepDrop::TYPE_SELECT2,
                    'data'=>$sampletype,
                    'options'=>['id'=>'sample-sample_type_id'],
                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['sample-testcategory_id'],
                        'placeholder'=>'Select Sample type',
                        'url'=>Url::to(['/lab/sample/listsampletype']),
                        'loadingText' => 'Loading Sampletype...',
                    ]
                ])
                
                ?>
            
             </div>
       
         </div>

         <div class="row">
             <div class="col-md-6">
             <?= $form->field($model, 'tests')->textInput(['maxlength' => true]) ?>
             </div>
             <div class="col-md-6">
             <?= $form->field($model, 'rstl_id')->textInput() ?>     
             </div>
         </div>

         <div class="row" style="float: right;padding-right: 30px">
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         <?php if($model->isNewRecord){ ?>
         <?= Html::resetButton('Reset', ['class' => 'btn btn-danger']) ?>
         <?php } ?>
         <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
     </div>


    <?php ActiveForm::end(); ?>

</div>


