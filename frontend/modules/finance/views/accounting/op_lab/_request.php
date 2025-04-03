<?php
use kartik\grid\GridView;
use yii\helpers\Html;
$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
        settotal();
   });    
   $(".select-on-check-all").change(function(){
        settotal();
   });
  
SCRIPT;
$this->registerJs($js);
?>

 <?php 
    $gridColumn = [
        [
            'class' => '\kartik\grid\SerialColumn',
            
         ],
         [
            'class' => '\kartik\grid\CheckboxColumn',
         ],
        [
          'attribute'=>'request_ref_num',
          'enableSorting' => false,
        ],
       
        [
            'attribute'=>'request_datetime',
             'value' => function($model) {
                    return date($model->request_datetime);
                },
            'pageSummary' => '<span style="float:right;">Total</span>',
            'enableSorting' => false,
        ],
        [
            'attribute'=>'total',
            'enableSorting' => false,
            'contentOptions' => [
                'style'=>'max-width:80px; overflow: auto; white-space: normal; word-wrap: break-word;'
            ],
            'hAlign' => 'right', 
            'vAlign' => 'middle',
            'width' => '7%',
            'format' => ['decimal', 2],
            'pageSummary' => '<span id="total">0.00</span>',
             
        ],
         /*[
            'attribute'=>'selected_request',
            'pageSummary' => '<span style="float:right;">Total</span>',
        ],*/
      
        
    ];
?>    

	   
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'grid',
        'pjax'=>true,
        'containerOptions'=> ["style"  => 'overflow:auto;height:300px'],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        
        'responsive'=>false,
        'striped'=>true,
        'hover'=>true,
      
        'floatHeaderOptions' => ['scrollingTop' => true],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Request</h3>',
            'type'=>'primary',

         ],
       
         'columns' =>$gridColumn,
         'showPageSummary' => true,
         /*'afterFooter'=>[
             'columns'=>[
                 'content'=>'Total Selected'
             ],
             
         ],*/
    ]); ?>
<script type="text/javascript">
    function settotal(){
         var keys = $('#grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
        $("#op-requestids").val(keys.join());
        $.post({
            url: '/finance/op/calculate-total?id='+keylist, // your controller action
            success: function(data) {
                var tot=parseFloat(data);
                var total=CurrencyFormat(tot,2);
                $('#total').html(total);
                 var payment_mode=$('#op-payment_mode_id').val()
                if(payment_mode==4){
                    
                    wallet=parseInt($('#wallet').val());
                    totalVal = parseFloat($('#total').html().replace(/[^0-9-.]/g, ''));
                    if( totalVal > wallet) {
                      alert("Insufficient customer wallet");
                      $('#op-purpose').prop('disabled', true);
                      $('#createOP').prop('disabled', true);
                    
                    }
                    else{
                        if(total !== 0){
                            $('#op-purpose').prop('disabled', false);
                            $('#createOP').prop('disabled', false);
                        }
                       
                    }
                }
            }
        });
    }
    
</script>