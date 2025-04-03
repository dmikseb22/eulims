<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\inventory\Servicetype;
use yii2assets\pdfjs\PdfJs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\Equipmentservice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipmentservice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'servicetype_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => ArrayHelper::map(Servicetype::find()->orderBy('servicetype')->asArray()->all(), 'servicetype_id', 'servicetype'),
        'options' => ['placeholder' => 'Choose Service Type'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Service Type');
    ?>

    <?php
     echo "<b>Start Date</b>";
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'startdate',
        'readonly' => true,
        'options' => ['placeholder' => 'Enter Date'],
        'value' => function($model) {
            return date("Y-m-d", $model->startdate);
        },
        'pluginOptions' => [
            'autoclose' => true,
            'removeButton' => false,
            'format' => 'yyyy-mm-dd'
        ],
        'pluginEvents' => [
            "change" => "function() {  }",
        ]
    ]);
    ?>

    <?php
     echo "<b>End Date</b>";
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'enddate',
        'readonly' => true,
        'options' => ['placeholder' => 'Enter Date'],
        'value' => function($model) {
            return date("Y-m-d", $model->enddate);
        },
        'pluginOptions' => [
            'autoclose' => true,
            'removeButton' => false,
            'format' => 'yyyy-mm-dd'
        ],
        'pluginEvents' => [
            "change" => "function() {  }",
        ]
    ]);
    ?>

    <?= $form->field($model, 'attachment')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-md-12">   
    <?php
    if($model->attachment){
        $url = Url::base()."/uploads/equipment/".$model->attachment;
        echo PdfJs::widget([
            'width'=>'100%',
            'height'=> '670px',
            'url'=>$url
        ]); 
    }else{
        echo "<strong>no sds yet.</strong>"; 
    }
    ?>?
    </div>
</div>

