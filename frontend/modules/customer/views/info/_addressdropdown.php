<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\address\Region;
use common\models\address\Barangay;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
?>
<i style="font-size: 8pt"><b style="color:#f39c12">Note - Dropdowns below can only be used within the Philippines</b></i>
<br/>
<label class="control-label">Region</label>
<?php 
echo Select2::widget([
    'name' => 'cregion',
    'data' => ArrayHelper::map(Region::find()->all(), 'region_id', 'reg_desc'),
    'theme' => Select2::THEME_BOOTSTRAP,
    'hideSearch' => false,
    'options' => [
        'id'=>'cregion'
    ],
    'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Region'],
]);
?>
<label class="control-label">Province</label>
<?php 
echo DepDrop::widget([
    'type'=>DepDrop::TYPE_SELECT2,
    'name' => 'province',
    'data' => null,
    // 'theme' => Select2::THEME_BOOTSTRAP,
    // 'hideSearch' => false,
    'options' => [
        'id'=>'cprovince'
    ],
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['cregion'],
        'placeholder'=>'Select Province',
        'url'=>Url::to(['/customer/info/getprovince']),
        'loadingText' => 'Loading provinces...',
    ]
]);
?>
<label class="control-label">Municipality</label>
 <?php 
echo DepDrop::widget([
    'type'=>DepDrop::TYPE_SELECT2,
    'name' => 'municipality',
    'data' => null,
    'options' => [
        'id'=>'cmunicipality'
    ],
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['cprovince'],
        'placeholder'=>'Select Municipality',
        'url'=>Url::to(['/customer/info/getmunicipality']),
        'loadingText' => 'Loading cities or municipalities...',
    ],
    ]);
?>
<?= $form->field($model, 'barangay_id')->widget(DepDrop::classname(), [
    'type'           => DepDrop::TYPE_SELECT2,
    'data'           =>  $model->isNewRecord ? null : ArrayHelper::map(Barangay::find()->all(), 'barangay_id', 'brgy_desc'),
    'options'        => ['id' => 'customer-barangay_id', 'name' => 'Customer[barangay_id]'],
    'select2Options' => ['pluginOptions' => ['allowClear' => false]],
    'pluginOptions'=>[
        'depends'=>['cmunicipality'],
        'placeholder'=>'Select Barangay',
        'url'=>Url::to(['/customer/info/getbarangay']),
        'loadingText' => 'Loading barangay...',
    ],
    // 'pluginEvents' => [ "depdrop:afterChange"=>"function(event, id, value) { 
    //     if (value == '') { $('.mybtn').prop('disabled',true);}else{ $('.mybtn').prop('disabled',false); } }", ],
])->label('Barangay'); ?> 
