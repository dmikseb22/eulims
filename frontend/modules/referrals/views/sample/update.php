<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Sample */

$this->title = 'Update Sample: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Samples', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sample-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            


            <?= $form->field($model, 'sampleType_id')->widget(Select2::classname(), [
                'data' => $data->sampletype,
                'language' => 'en',
                 'options' => [
                    'placeholder' => 'Select any among sampletypes',
                ],
            ])->label('Sample Type'); ?>

            <?= $form->field($model, 'sampleName')->textInput() ?>
    
            <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

            <div class="row" style="float: right;padding-right: 15px">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary','id'=>'btn-update']) ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
