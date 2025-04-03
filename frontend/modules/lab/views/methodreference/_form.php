<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;
use common\models\lab\Sampletype;
use common\models\lab\TestName;
use common\models\lab\Methodreference;
use yii\helpers\Url;

$methodlist= ArrayHelper::map(Methodreference::find()->all(),'method_reference_id','method');
/* @var $this yii\web\View */
/* @var $model common\models\lab\Methodreference */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="methodreference-form">
    <div class="alert alert-danger" style="background: #ffc0cb !important;margin-top: 1px !important;">
       <a href="#" class="close" data-dismiss="alert" >×</a>
      <p class="note" style="color:#d73925"><b>Reference with value "-" will not be counted in accomplishment report: </b><br/> They will be tagged either as Package name or On-site Calibration</p>
       
    </div>

    <div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
       <a href="#" class="close" data-dismiss="alert" >×</a>
      <p class="note" style="color:#265e8d"><b>Method Reference will be used in creating test/analysis:</b><br/> Make sure to not use <b>"-"</b> when specifying no references, you can use "none" instead.</p>
   
    </div>

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fee')->textInput() ?>

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
