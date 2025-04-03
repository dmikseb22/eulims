<?php
use kartik\grid\GridView;
use yii\helpers\Html;
$js=<<<SCRIPT
  $(".kv-row-checkbox").click(function(){
      total();
   });    
   $(".select-on-check-all").change(function(){
      total();
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
          'attribute'=>'details',
          'enableSorting' => false,
        ],
       
        [
            'attribute'=>'amount',
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
    ];
?>    

	   
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'grid',
        'pjax'=>true,
        'containerOptions'=> ["style"  => 'overflow:auto;height:auto'],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'summary' => '',
        'responsive'=>false,
        'striped'=>true,
        'hover'=>true,
      
        'floatHeaderOptions' => ['scrollingTop' => true],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Select</h3>',
            'type'=>'primary',
         ],
       
         'columns' =>$gridColumn,
         'showPageSummary' => true,
         'toolbar' => [
                ],
    ]); ?>
  <div class="form-group pull-right">
    <button  id='btnSaveCollection' class='btn btn-success' ><i class='fa fa-save'></i> Save Collection</button>
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
  </div>
<script type="text/javascript">
    function total(){
        var keys = $('#grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
        $.post({
            url: 'calculate-total?id='+keylist, // your controller action
          // data: {keylist: keylist},
            success: function(data) {
                var tot=parseFloat(data);
                var total=CurrencyFormat(tot,2);
                $('#total').html(total);
            }
        });
    }
     $('#btnSaveCollection').on('click',function(e) {
        var keys = $('#grid').yiiGridView('getSelectedRows');
        var keylist= keys.join();
        $.post({
            url: 'save-collection?id='+keylist+'&receiptid=<?php echo $receiptid ?>'+'&collection_id=<?php echo $collection_id ?>', // your controller action
            dataType: 'json',
            success: function(data) {
                if(data.success === true)
                {
                    swal('fgdfgfd');
                }
                else{
                    
                }
               
            }
        });
        
     });
</script>
