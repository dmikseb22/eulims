<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Customertransaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customertransaction-form" style="padding-bottom: 10px">

    <?php $form = ActiveForm::begin([
    ]); ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true,'type'=>'number','onChange'=>'myFunction(this.value)']) ?>

    <?= $form->field($model, 'customerwallet_id')->hiddenInput(['value' => $customerwallet_id])->label(false); ?>

    <div class="form-group pull-right">
        
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success mybtn' : 'btn btn-primary mybtn',
            'disabled'=>true,
            'data' => [
            'confirm' => 'Are you sure you want to add credits to this account ?',
        ],]) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>



    <?php ActiveForm::end(); ?>


</div>
<script>
function myFunction(val) {
    if((val!=0)||(val!=""))
        $('.mybtn').prop('disabled',false);
    else
        $('.mybtn').prop('disabled',true);
}
</script>