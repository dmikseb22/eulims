<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

?>
<div class="box-header modal-white">
    <?php $form = ActiveForm::begin(); ?>
    <div class="input-group">
        <?= $form->field($model, 'factor_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($factors,'factor_id','title'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select Factor','readonly'=>'readonly'],
                'pluginOptions' => [
                    'allowClear' => false
                ]
            ])->label('Factor'); ?>
        <span class="input-group-btn" style="padding-top: 25.5px">
            
        <button onclick="LoadModal('Link New Factor', '/reports/finance/analytic/createfactor?yearmonth=<?=$model->yearmonth?>&labid=<?=$lab_id?>');" class="btn btn-success" type="button" alt="New Factor"><i class="fa fa-plus"></i></button>
        </span>
    </div>
    <br>
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