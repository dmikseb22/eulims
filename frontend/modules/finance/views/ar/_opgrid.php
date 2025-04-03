<?php
use kartik\grid\GridView;

/**
 * Description of _opgrid
 *
 * @author OneLab
 */
$js=<<<SCRIPT
    function getKeys(){
        var dkeys=$("#OPGrid").yiiGridView("getSelectedRows");
        $("#ext_billing-opids").val(dkeys);
        var SearchFieldsTable = $(".kv-grid-table>tbody");
        var trows = SearchFieldsTable[0].rows;
        var Total=0.00;
        var amt=0.00;
        $.each(trows, function (index, row) {
            var data_key=$(row).attr("data-key");
            for (i = 0; i < dkeys.length; i++) { 
                if(data_key==dkeys[i]){
                    amt=StringToFloat(trows[index].cells[4].innerHTML);
                    Total=Total+parseFloat(amt);
                }
            }
        }); 
        $("#ext_billing-amount-disp").val(Total);
        $("#ext_billing-amount").val(Total);
        $("#ext_billing-amount-disp").maskMoney('mask', Total);
    }
    $("#ext_billing-customer_id").change(function(){
        $(this).select2('close');
        $("#OPGridContainer").html("<div style='text-align:center;'><img src='/images/img-loader64.gif' alt=''></div>"); 
        $.get("/finance/ar/getopgrid", {
            id: this.value,
        }, function(result){
           if(result){
              $("#OPGridContainer").html(result); 
           }
        });
        $(this).select2('open');
        $(this).attr("tabIndex",1);
    });
    $(".kv-row-checkbox").change(function(){
       getKeys();
    });   
    $(".select-on-check-all").change(function(){
       getKeys();
    });     
        
SCRIPT;
$this->registerJs($js);

echo GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'OPGrid',
        'pjax'=>true,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'containerOptions'=>['style'=>'overflow: auto;height: 200px'],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'toolbar'=>[],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
               // 'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
               'footer'=>false   
            ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'class'=>'kartik\grid\CheckboxColumn',
            ],
            'transactionnum',
            'order_date',
            [
                'attribute'=>'total_amount',
                'hAlign' => 'right',
                'contentOptions' => ['class' => 'op-amount'],
                'label'=>'Amount',
                'value'=>function($model){
                    return number_format($model->total_amount,2);
                }
            ],
        ],
    ]); 