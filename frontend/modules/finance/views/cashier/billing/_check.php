<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\money\MaskMoney;
use kartik\widgets\DatePicker;


/* @var $this yii\web\View */
$js=<<<SCRIPT
   var TotalSoa=CurrencyFormat($("#TotalSoa").val(),2);
   var table=new tableobject("checkTable");
   table.truncaterow();
   table.insertfooter(['','','Balance:','0.00'],['kv-page-summary warning','kv-page-summary warning','kv-page-summary warning kv-align-right','kv-page-summary warning kv-align-right kv-balance']);     
   table.insertfooter(['','','Total Check Amount:','0.00'],['kv-page-summary warning','kv-page-summary warning','kv-page-summary warning kv-align-right','kv-page-summary warning kv-align-right kv-total-check']);
   table.insertfooter(['','','Total SOA',TotalSoa],['kv-page-summary warning','kv-page-summary warning','kv-page-summary warning kv-align-right','kv-page-summary warning kv-align-right kv-total']);
   $("#btnAddBankDetails").click(function(){
        InsertRow();
   }); 
   $(".form-control").on('select',function(){
       $("#btnAddBankDetails").prop('disabled',false); 
   });
   $("#checkTable").on('select',function(e){
       
   });
   $("#checkTable").on('keydown',function(e){
       var index=e.index;
       if(e.which==46){//delete key
          bootbox.confirm({
            title: "Remove Row",
            message: "Do you want to remove the current row?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm'
                }
            },
            callback: function (result) {
                if(result){
                    table.deletecurrentrow();
                    GetTotal();
                }
            }
        });
       }
   });
   function ClearDetails(){
      $("#bank_name").val("");
      $("#checknumber").val("");
      $("#check_amount-disp").maskMoney('mask', 0.00);
      $("#check_amount-disp").val(0.00);
      $("#check_amount-disp").val(0);
      $("#btnAddBankDetails").prop('disabled',true);
   }
   function InsertRow(){
      var totrow=table.contentrowcount;
      var fields=[
          $("#bank_name").val(),
          $("#checknumber").val(),
          $("#checkdate").val(),
          CurrencyFormat($("#check_amount").val(),2)
      ];
      var fieldarr=[
          "kv-align-left",
          "kv-align-center",
          "kv-align-center",
          "kv-align-right kv-amount",
      ];
      table.insertrow(fields,fieldarr,-1);
      GetTotal();
      ClearDetails();
   }
   function GetTotal(){
      var total=0;
      var rows=table.rows();
      for (var i = 0; i < rows.length; i++) { 
          var row=rows[i];
          row.setAttribute("id","table_obj"+i);
          row.setAttribute("data_key",i);
          row.setAttribute("tabindex",i);
          var cell=row.cells[3];
          total=total+StringToFloat(cell.innerHTML);
      }
      var totalchk=CurrencyFormat(total,2);
      $(".kv-total-check").html(totalchk);
      $("#TotalCheck").val(total);
      var Balance=StringToFloat(TotalSoa)-total;
        
      $("#total-disp").val(total);
      $("#total").val(total);
      $("#total-disp").maskMoney('mask', total);  
        
      $(".kv-balance").html(CurrencyFormat(Balance,2));
      console.log("Result: "+table.rowsToJSON());
      $("#check_details").val(table.rowsToJSON());
   }    
SCRIPT;
$this->registerJs($js);
$gridColumns=[
    'bank',
    [
        'attribute'=>'checknumber',
        'label'=>'Check #',
        'hAlign'=>'center'
    ],
    [
        'attribute'=>'checkdate',
        'label'=>'Check Date',
        'hAlign'=>'center',
    ],
    [
        'attribute'=>'amount',
        'label'=>'Amount',
        'hAlign'=>'right',
    ]
];
echo GridView::widget([
    'id' => 'kv-grid-checktable',
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'tableOptions'=>['id'=>'checkTable'],
    'options'=>['class'=>'test'],
    'pjax' => true, // pjax is set to always true for this demo
    // set your toolbar
    'toolbar' =>  [
       
    ],
    // set export properties
    'export' => [
        'fontAwesome' => true
    ],
    // parameters from the demo form
    'bordered' => true,
    'striped' => false,
    'condensed' => true,
    'responsive' => true,
    'hover' => false,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode("Check Details"),
        'before'=>Html::button("Add Bank Details",['class'=>'btn btn-primary','onclick'=>'$("#BankDetails").show()'])
    ],
    'persistResize' => false,
    'toggleDataOptions' => ['minCount' => 10],
    
]);
?>
<div id="BankDetails" class="panel panel-primary col-md-10" style="position: fixed; top: 340px;display: none;z-index: 1">
    <div class="panel-heading">Add Bank Details <button type="button" style="float: right" class="close" onclick="$('#BankDetails').hide()" aria-hidden="true">×</button></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <label class="control-label" for="bank_name">Bank Name</label>
                <input id="bank_name" type="text" placeholder="Enter Bank Name" class="form-control" />
            </div>
            <div class="col-sm-6">
                <label class="control-label" for="checknumber">Check #</label>
                <input id="checknumber" type="text" placeholder="Enter Check #" class="form-control" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label class="control-label" for="checkdate">Check Date</label>
                <?php
                echo DatePicker::widget([
                    'name' => 'checkdate',
                    'id'=>'checkdate',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'value' => date("Y-m-d"),
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose'=>true,  
                    ]
                ]);
                ?>
            </div>
            <div class="col-sm-6">
                <label class="control-label" for="amount">Amount</label>
                <?php
                   echo MaskMoney::widget([
                    'name' => 'amount',
                    'id'=>'check_amount',
                    'value' => 0.00,
                    'pluginOptions' => [
                        'prefix' => '₱ ',
                        'thousands' => ',',
                        'decimal' => '.',
                        'precision' => 2
                    ],
                ]);

                ?>
            </div>
        </div>
        <div class="row" style="padding-top: 15px;background-color: white">
            <div class="col-md-12 pull-right">
                <button id="btnCheckClose" type="button" onclick="$('#BankDetails').hide()" class="btn btn-default pull-right">Close</button>
                <button id="btnAddBankDetails" type="button" class="btn btn-primary pull-right" style="padding-right: 20px"><i class="fa fa-save"> </i> Add Bank Details</button>
            </div>
        </div>
    </div>
</div>