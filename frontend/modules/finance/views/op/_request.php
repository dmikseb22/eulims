<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use frontend\modules\finance\components\models\Ext_Request;
use common\models\lab\Request;
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
        ['class' => 'kartik\grid\SerialColumn'
        ],
        [
             'class' => '\kartik\grid\CheckboxColumn',
             'checkboxOptions' => function($model) {
                if($model['posted'] == 1 && $model['payment_status_id'] <> 2){
                   return ['disabled' => true];
                }else{
                   return [];
                }
             },
        ],
        [
            'attribute'=>'CustomerName',
            'enableSorting' => false,
            'contentOptions' => [
                'style'=>'overflow: auto; white-space: normal; word-wrap: break-word;'
            ],
        ],            
        [
          'attribute'=>'request_ref_num',
          'enableSorting' => false,
          'format'=>'raw',
          'value' => function($model){
            return Html::a($model['request_ref_num'], ['/lab/request/view?id='.$model['request_id']],['class'=>'btn-info','target'=>"_blank", 'data-pjax'=>"0"]);
          }
        ],
        [
            'attribute'=>'payment_status_id',
            'label'=>'Payment Status',
            'format'=>'raw',
             'value' => function($model) {
                    $request= Request::find($model['request_id'])->one(); 
                    $Obj=$request->getPaymentStatusDetails($model['request_id']);
                    if($Obj){
                       return "<span class='badge ".$Obj[0]['class']." legend-font' style='width:80px!important;height:20px!important;'>".$Obj[0]['payment_status']."</span>";
                    }else{
                        return "<span class='badge btn-primary legend-font' style='width:80px!important;height:20px!important;'>Unpaid</span>";
                    }
            },
            'enableSorting' => false,
             'hAlign'=>'center',      
        ],               
        [
            'attribute'=>'total',
            'enableSorting' => false,
            'contentOptions' => [
                'style'=>'max-width:80px; overflow: auto; white-space: normal; word-wrap: break-word;'
            ],
            'value' => function($model) {
                 $request= Ext_Request::find()->where(['request_id' => $model['request_id']])->one();
                 $total=$request['total'];
                 return $request->getBalance($model['request_id'],$total);
            },
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
         'toolbar'=> [],
         /*'afterFooter'=>[
             'columns'=>[
                 'content'=>'Total Selected'
             ],
             
         ],*/
    ]); ?>

 <?php 
 if ($stat){
      ?><div class="form-group pull-right">
    <button  id='btnSaveCollection' class='btn btn-success' ><i class='fa fa-save'></i> Add Payment Item</button>
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
  </div>
<?php

 }
 else{
     $opid="";
 }
?>


<script type="text/javascript">
    function settotal(){
        
        //
        var dkeys=$("#grid").yiiGridView("getSelectedRows");
        $("#ext_billing-opids").val(dkeys);
        var SearchFieldsTable = $(".kv-grid-table>tbody");
        var trows = SearchFieldsTable[0].rows;
        var Total=0.00;
        var amt=0.00;
        var rqs='';
        var ids=[];
        $.each(trows, function (index, row) {
            var data_key=$(row).attr("data-key");
            for (i = 0; i < dkeys.length; i++) { 
                if(data_key==dkeys[i]){
                    amt=StringToFloat(trows[index].cells[5].innerHTML);
                    Total=Total+parseFloat(amt);
                }
            }
        }); 
     
        $("#op-requestids").val(dkeys);
     
        var tot=parseFloat(Total);
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
    
    $('#btnSaveCollection').on('click',function(e) {
        var dkeys=$("#grid").yiiGridView("getSelectedRows");
        var ids=dkeys;
        
        if (ids == ""){
            alert("Please Select Payment Item");
        }
        else{
             $.post({
            url: 'save-paymentitem?request_ids='+ids+'&opid=<?php echo $opid ?>', // your controller action
      
            success: function(data) {
               location.reload();
            }
            });
        }
       
        
     });
</script>