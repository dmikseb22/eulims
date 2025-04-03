<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Sample */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sample-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
    
            <?= $form->field($model, 'reportDue')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Report Due'],
                'value'=>function($model){
                     return date("m/d/Y",$model->reportDue);
                },
                   //'setOnEmpty' => true, 
                    'value' => '',
                'pluginOptions' => [
                        'autoclose' => true,
                        // 'setOnEmpty' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd'
                ],
                    'pluginEvents'=>[
                        "change" => "",
                    ]
                ])->label('Turn Around Time')?>

            <div class="row" style="float: right;padding-right: 15px">
                <?= Html::submitButton('Send',['class' => 'btn btn-primary','id'=>'btn-update']) ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
