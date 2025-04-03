<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testname */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testname-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'testName')->textInput(['maxlength' => true]) ?>
    <?php
        $model->status_id='Active';
    ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model,'status_id')->widget(Select2::classname(),[
                    'data' => ['1'=>'Active', '0'=>'Inactive'],
                    'theme' => Select2::THEME_KRAJEE,
                    'options' => ['id'=>'sample-testcategory_id'],
                    'pluginOptions' => ['allowClear' => true],
            ])
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'max_storage')->textInput(['maxlength' => true]) ?>
        </div>
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
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
