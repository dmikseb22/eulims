<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use frontend\modules\finance\components\models\Ext_Request;
use common\models\lab\Request;
use common\components\Functions;
use kartik\widgets\DatePicker;
use \yii\helpers\ArrayHelper;
use common\models\lab\Customer;
$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
        settotal();
   });    
   $(".select-on-check-all").change(function(){
        settotal();
   });
  
SCRIPT;
$this->registerJs($js);
$func=new Functions();
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'grid',
        'pjax'=>true,
        'containerOptions'=> ["style"  => 'overflow:auto;height:500px'],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        
        'responsive'=>false,
        'striped'=>true,
        'hover'=>true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-book"></i>  Request',
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
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
            'request_ref_num',
          /*  [
                'label'=>'Request Date',
                'attribute'=>'request_datetime',
                'value'=>function($model){
                    //return date('d/m/Y H:i:s',strtotime($model->request_datetime));
                    return ($model->request_type_id == 2 && $model->request_datetime == '0000-00-00 00:00:00') ? null : date('d/m/Y H:i:s',strtotime($model->request_datetime));
                },
                'filter'=>DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'request_datetime',
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'options' => ['placeholder' => 'Select date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]),
            ], */
            
           
            [
                'attribute' => 'customer_id',
                'label' => 'Customer Name',
                'value' => function($model) {
                    if($model->customer){
                        return $model->customer->customer_name;
                    }else{
                        return "";
                    }
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Customer::find()->asArray()->all(), 'customer_id', 'customer_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Customer Name', 'id' => 'grid-op-search-customer_id']
            ],
            [
                'label'=>'Total',
                'attribute'=>'total',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
                'pageSummary' => '<span id="total">0.00</span>',
            ],
          
        ],
        'showPageSummary' => true,          
]); ?>

<div class="form-group pull-right">
    <button  id='btnSave' class='btn btn-success' ><i class='fa fa-save'></i>Save</button>
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
  </div>
<script type="text/javascript">
    function settotal(){
        
        //
        var dkeys=$("#grid").yiiGridView("getSelectedRows");
       // $("#ext_billing-opids").val(dkeys);
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
                    amt=StringToFloat(trows[index].cells[4].innerHTML);
                    Total=Total+parseFloat(amt);
                }
            }
        }); 
     
      //  $("#op-requestids").val(dkeys);
     
        var tot=parseFloat(Total);
        var total=CurrencyFormat(tot,2);
        $('#total').html(total);
    
    }
    
     $('#btnSave').on('click',function(e) {
        var dkeys=$("#grid").yiiGridView("getSelectedRows");
        var ids=dkeys;
        //alert(ids);
        if (ids == ""){
            alert("Please Select Item");
        }
        else{
             $.post({
               url: 'save-paymentitem?request_ids='+ids+'&receiptid=<?php echo $receipt_id ?>', // your controller action
            dataType: 'json',
            success: function(data) {
               location.reload();
            }
            });
        }
       
        
     });
    
</script>