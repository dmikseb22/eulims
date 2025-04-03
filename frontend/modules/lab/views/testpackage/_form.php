<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\lab\Sampletype;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\lab\testpackage */
/* @var $form yii\widgets\ActiveForm */

$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');

?>

<div class="testpackage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'package_name')->textInput() ?>

    <?= $form->field($model, 'package_rate')->textInput() ?>

   
      
    <?= $form->field($model,'lab_sampletype_id')->widget(Select2::classname(),[
                    'data' => $sampletypelist,
                    'theme' => Select2::THEME_KRAJEE,
                    //'multiple'=>'true',
                    'options' => ['id'=>'sample-testcategory_id'],
                    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Sample Type'],
            ])
        ?>

    <?= $form->field($model, 'testname_methods')->widget(DepDrop::classname(), [
            'type'=>DepDrop::TYPE_SELECT2,
            'data'=>$sampletype,
           
            'options'=>['id'=>'sample-sample_type_id'],
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
               
                'depends'=>['sample-testcategory_id'],
                'multiple'=>'true',
                'placeholder'=>'Select Test Name',
                'url'=>Url::to(['/lab/analysis/listsampletype']),
                'loadingText' => 'Loading Test Names...',
            ]
        ])
        ?>

  

    <?= $form->field($model, 'added_by')->textInput() ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
