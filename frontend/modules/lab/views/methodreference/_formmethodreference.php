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
