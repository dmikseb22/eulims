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

$(".kv-row-checkbox").change(function(){
    var keys = $('#testnamemethod-grid').yiiGridView('getSelectedRows');
    var keylist = keys.join();
    $("#package-tests").val(keylist); 

   
   
 });    

 $(".select-on-check-all").change(function(){
  var keys = $('#testnamemethod-grid').yiiGridView('getSelectedRows');
  var keylist = keys.join();
  $("#package-tests").val(keylist);
  
  
 });


function addpackage(mid){  
    $.ajax({
        url: '/lab/package/addpackage',
        method: "post",
        data: {id: mid},
        beforeSend: function(xhr) {
           $('.image-loader').addClass("img-loader");
           }
        })
        .done(function( response ) {  
            //render partial nalang 
            $("#workflow").html(response); 
            $("#testname-grid").yiiGridView("applyFilter");   
        });
}


SCRIPT;
$this->registerJs($js);


?>
        <?= GridView::widget([
        'dataProvider' => $testnamedataprovider,
        'id'=>'testnamemethod-grid',
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'containerOptions'=>[
            'style'=>'overflow:auto; height:320px',
        ],
        'floatHeaderOptions' => ['scrollingTop' => true],
        'responsive'=>true,
        'striped'=>true,
        'hover'=>true,
        'bordered' => true,
        'panel' => [
           'heading'=>'<h3 class="panel-title">Tests</h3>',
           'type'=>'primary',
           'before' => '',
           'after'=>false,
        ],
        'toolbar' => false,
        'columns' => [
            ['class' => '\kartik\grid\CheckboxColumn'],
            [     
                'label' => 'Laboratory',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 15%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($model) {
                    $lab_query = Lab::find()->where(['lab_id'=>$model->lab_id])->one();
        
                    if ($lab_query){
                        return $lab_query->labname;
                    }else{
                        return "";
                    }
                 }                        
            ],
            [     
                'label' => 'Sample Type',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 15%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($model) {
                    $sampletype_query = Sampletype::find()->where(['sampletype_id'=>$model->sampletype_id])->one();
        
                    if ($sampletype_query){
                        return $sampletype_query->type;
                    }else{
                        return "";
                    }
                 }                        
            ],
            [     
                'label' => 'Test Name',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 15%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($model) {
                    $testname_query = Testname::find()->where(['testname_id'=>$model->testname_id])->one();
        
                    if ($testname_query){
                        return $testname_query->testName;
                    }else{
                        return "";
                    }
                 }                        
            ],
            [     
                'label' => 'Method',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 40%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($model) {
                    $method_query = Methodreference::find()->where(['method_reference_id'=>$model->method_id])->one();
        
                    if ($method_query){
                        return $method_query->method;
                    }else{
                        return "";
                    }
                 }                        
            ],
            [     
                'label' => 'Reference',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($model) {
                    $method_query = Methodreference::find()->where(['method_reference_id'=>$model->method_id])->one();
                    if ($method_query){
                        return $method_query->reference;
                    }else{
                        return "";
                    }
                            
                 }                        
            ],
            [    
                'label' => 'Fee',
                'format' => 'raw',
                'width'=> '150px',
                'contentOptions' => ['style' => 'width: 10%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($model) {
                    $method_query = Methodreference::find()->where(['method_reference_id'=>$model->method_id])->one();
                    if ($method_query){
                        
                        return number_format($method_query->fee,2);
                    }else{
                        return "";
                    }
                 }                
            ]
       ],
    ]); ?>
       
          
      
      
</div>
