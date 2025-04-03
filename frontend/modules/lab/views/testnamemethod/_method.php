<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Services;
use common\models\lab\Lab;
use common\models\lab\Testname;
use common\models\lab\Methodreference;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;

$js=<<<SCRIPT

$("#testname-grid").change(function(){
    var key = $("input[name='method_id']:checked").val();
    $("#testnamemethod-method_id").val(key);

});    

  

SCRIPT;
$this->registerJs($js, $this::POS_READY);

?>






<?= GridView::widget([
        'dataProvider' =>  $testnamedataprovider,
        'pjax' => true,    
        'id'=>'testname-grid',
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'containerOptions'=>[
            'style'=>'overflow:auto; height:380px',
        ],
        'columns' => [
            [
                'class' =>  '\kartik\grid\RadioColumn',
                'name' => 'method_id',
                'showClear' => true,
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center','style'=>'max-width:20px;'],
                'radioOptions' => function ($model) {
                    return [
                        'value' => $model['method_reference_id'],
                       // 'checked' => $model['method_reference_id'],
                    ];
                },
            ],
            [     
                'label' => 'Method',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 30%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                    return $data->method;
                 }                        
            ],
            [     
                'label' => 'Reference',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                    return $data->reference;
                            
                 }                        
            ],
            [    
                'label' => 'Fee',
                'format' => 'raw',
                'width'=> '150px',
                'contentOptions' => ['style' => 'width: 10%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                    return $data->fee;
                 }                
            ],
       ],
    ]); ?>