<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;


?>
<div class="box-header modal-white">
    <?php $form = ActiveForm::begin(); ?>
    <div class="input-group">

        <?= $form->field($factor, 'title')->label('Factor Name'); ?>
        <?= $form->field($factor, 'type')->widget(Select2::classname(), [
                'data' => ['0'=>'Negative','1'=>'Positive'],
                'language' => 'en',
                'options' => ['placeholder' => 'Select Effect'],
                'pluginOptions' => [
                    'allowClear' => false
                ]
            ])->label('Factor Effect'); ?>
    </div>
    
    <div class="input-group col-md-12">
        <?= $form->field($model, 'name')->label('Target'); ?>
    </div>
        <?= $form->field($model, 'remarks'); ?>
        
    <div class="form-group">
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
        <?php } ?>

        <?= Html::submitButton('Link Factor', ['class' => 'btn btn-primary pull-right']) ?>
    </div>

    
	<?php ActiveForm::end(); ?>
</div>