<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\Functions;
use common\models\lab\Cancelledrequest;
use common\models\lab\Discount;
use common\models\lab\Request;
use common\models\lab\Tagging;
use common\models\lab\Sample;
use common\models\lab\Tagginganalysis;
use common\models\lab\Sampletype;
use common\models\finance\Paymentitem;
use common\models\finance\Receipt;

use common\models\lab\Package;
use yii\bootstrap\Modal;

$Connection = Yii::$app->financedb;
$func = new Functions();


$this->title = empty($model->request->request_ref_num) ? "Create New Request" : $model->request->request_ref_num;

$Year=date('Y', strtotime($model->request->request_datetime));
$paymentitem= Paymentitem::find()->where(['request_id'=> $model->request->request_id])->andWhere(['not', ['receipt_id' => null]])->all();
$forqty = $model->request->request_ref_num; //var use to check if editable is readonly or not

$request_identification=$model->request->request_id;

$Request_Ref=$model->request->request_ref_num;
$Cancelledrequest= Cancelledrequest::find()->where(['request_id'=>$model->request->request_id])->one();
if($Cancelledrequest){
    $Reasons=$Cancelledrequest->reason;
    $DateCancelled=date('m/d/Y h:i A', strtotime($Cancelledrequest->cancel_date));
    $CancelledBy=$func->GetProfileName($Cancelledrequest->cancelledby);
}else{
    $Reasons='&nbsp;';
    $DateCancelled='';
    $CancelledBy='';
}
if($Request_Ref){//With Reference
    $enableRequest=true;
    $disableButton="disabled";///reports/preview?url=/lab/request/print-request?id=10
    $EnablePrint="<a href='/lab/request/print-request?id=".$model->request->request_id."' class='btn btn-primary' style='margin-left: 5px'><i class='fa fa-print'></i> Print Request</a>";
    $ClickButton=''; //temporary , only lab manager
   
    //get the roles
    $roles = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id);
    foreach ($roles as $role) {

        if(($role->name == "pro-CRO") ||($role->name == "pro-MANAGER"))
             $ClickButton='addSample(this.value,this.title)';
    }
    $btnID="";
}else{ // NO reference number yet
    $enableRequest=false;
    $ClickButton='addSample(this.value,this.title)';
    $disableButton="";
    $EnablePrint="<span class='btn btn-primary' disabled style='margin-left: 5px'><i class='fa fa-print'></i> Print Request</span>";
    $btnID="id='btnSaveRequest'";
}

$Params=[
    'mRequestID'=>$model->request->request_id
];
$row=$func->ExecuteStoredProcedureOne("spGetPaymentDetails(:mRequestID)", $Params, $Connection);
$payment_total=number_format($row['TotalAmount'],2);
$orNumbers=$row['ORNumber'];
$orDate=$row['ORDate'];
$UnpaidBalance1="";
$UnpaidBalance=$model->request->total;
$totalpaymentitem = 0;
// overides the unpaidbalance variable
if($orNumbers && $paymentitem){
    $orNumbers = "";
    $orDate="";
    foreach ($paymentitem as $p_item) {
        //check if payment item's or is not cancelled
        $thereceipt = Receipt::find()->where(['receipt_id'=>$p_item->receipt_id])->one();

        if($thereceipt->cancelled==0){
            $totalpaymentitem += $p_item->amount;
            $orNumbers .= $thereceipt->or_number." ";
            $orDate.= $thereceipt->receiptDate." ";
        }
    }
    $UnpaidBalance1 = $model->request->total-$totalpaymentitem;
    $UnpaidBalance=number_format($UnpaidBalance1,2);
}

$PrintEvent=<<<SCRIPT
  $("#btnPrintRequest").click(function(){
      alert("Printing...");
  });   
SCRIPT;
$this->registerJs($PrintEvent);
?>



<div class="section-request"> 
<div class="request-view ">
    <div class="container table-responsive">
        <?php
            echo DetailView::widget([
            'model'=>$model->request,
            'responsive'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'buttons1' => '',
            'attributes'=>[
                [
                    'group'=>true,
                    'label'=>'Request Details ',
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'request_ref_num', 
                            'label'=>'Request Reference Number',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Customer / Agency',
                            'format'=>'raw',
                            'value'=> $model->request->customer ? stringToSecret($model->request->customer->customer_name) : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Request Date',
                            'format'=>'raw',
                            'value'=>Yii::$app->formatter->asDate($model->request->request_datetime, 'php:F j, Y'),
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Address',
                            'format'=>'raw',
                            'value'=>$model->request->customer ? stringToSecret($model->request->customer->completeaddress) : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                    
                ],
                [
                    'columns' => [
                        [
                            'label'=>'Request Time',
                            'format'=>'raw',
                            'value'=>date("h:i A",strtotime($model->request->request_datetime)),//Yii::$app->formatter->asDate($model->request->request_datetime, 'php:g:i a'),
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Tel no.',
                            'format'=>'raw',
                            'value'=>$model->request->customer ? stringToSecret($model->request->customer->tel) : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'report_due',
                            'label'=>'Report Due Date',
                            'format'=>'raw',
                            'value'=>Yii::$app->formatter->asDate($model->request->report_due, 'php:F j, Y'),
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Fax no.',
                            'format'=>'raw',
                            'value'=>$model->request->customer ? stringToSecret($model->request->customer->fax) : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'group'=>true,
                    'label'=>'Payment Details',
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [
                            'label'=>'OR No.',
                            'value'=>$orNumbers,
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Collection',
                            'format'=>'raw',
                            'value'=>"₱".number_format($totalpaymentitem,2),
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'label'=>'OR Date',
                            'value'=>$orDate,
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'label'=>'Unpaid Balance',
                            'format'=>'raw',
                            'value'=>"₱".$UnpaidBalance,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                ],
                [
                    'group'=>true,
                    'label'=>'Transaction Details',
                    'rowOptions'=>['class'=>'info']
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'conforme', 
                            'value'=>stringToSecret($model->request->conforme),
                            'format'=>'raw',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'receivedBy',
                            'format'=>'raw',
                            'value'=>stringToSecret($model->request->receivedBy),
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],
                    
                ],
                [
                    'columns' => [
                      
                        [
                            'attribute'=>'contact_num',
                            'format'=>'raw',
                            'value'=>stringToSecret($model->request->contact_num),
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'attribute'=>'created_at', 
                            'format'=>'raw',
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                    
                ],
            ],

        ]);
        ?>
    </div>

    <div class="container table-responsive">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                [
                    'attribute'=>'sample_code',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'samplename',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'description',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($data){
                        return  $data->description;
                    },
                ],
                [
                    'attribute'=>'customer_description',
                    'header'=>'Description provided by Customer',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($data){
                        return $data->customer_description;
                    },
                ],
            ];

            echo GridView::widget([
                'id' => 'sample-grid',
                'dataProvider'=> $sampleDataProvider,
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'columns' => $gridColumns,
            ]);
        ?>
        </div>
    </div>
    <div class="container">
    <?php

        $samplecount = $sampleDataProvider->getTotalCount();
        if ($samplecount==0){
            $enableRequest = true;
        }else{
            $enableRequest = false;
        }

        if( $samplecount == 0){
            $enablePackage = true;
        } else {
            $enablePackage = false;
        }

        $analysisgridColumns = [
            [
                'attribute'=>'sample_name',
                'header'=>'Sample',
              
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function($model) {
                    return $model->sample ? $model->sample->samplename : '-';
                },
               
            ],
            [
                'attribute'=>'sample_code',
                'header'=>'Sample Code',
                'value' => function($model) {
                    return $model->sample ? $model->sample->sample_code : '-';
                },
                'enableSorting' => false,            ],
            [
                'attribute'=>'testname',
                'header'=>'Test/ Calibration Requested',
                'enableSorting' => false,
            ],
            [
                'attribute'=>'method',
                'header'=>'Test Method',
                'enableSorting' => false,  
            ],
            
            [
                   // 'class' => 'kartik\grid\EditableColumn',
                    //'asPopover' => true,
                    'attribute' => 'quantity', 
                    'hAlign' => 'left', 
                    'vAlign' => 'middle',
                    'width' => '25%',
                    'format' => ['decimal', 2],
                ],
            [
                'attribute'=>'fee',
                'header'=>'Unit Price',
                'enableSorting' => false,
                'hAlign'=>'right',
                'value'=>function($model){
                    return number_format($model->fee,2);
                },
                'hAlign' => 'right', 
                'vAlign' => 'left',
                'format' => 'raw',
                'width' => '7%',
            ],
            [
                'header'=>'Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                if($model->cancelled){
                     return "<span class='badge btn-danger' style='width:90px;height:20px'>CANCELLED</span>";
                }

                $tagging = Tagging::findOne(['analysis_id' => $model->analysis_id]); 
                if ($tagging){

                    if ($tagging->tagging_status_id==1) {
                           return "<span class='badge btn-primary' style='width:90px;height:20px'>ONGOING</span>";
                       }else if ($tagging->tagging_status_id==2) {
                           return "<span class='badge btn-success' style='width:90px;height:20px'>COMPLETED</span>";
                       }
                       else if ($tagging->tagging_status_id==3) {
                           return "<span class='badge btn-warning' style='width:90px;height:20px'>ASSIGNED</span>";
                       }
                       else if ($tagging->tagging_status_id==4) {
                           return "<span class='badge btn-danger' style='width:90px;height:20px'>CANCELLED</span>";
                       }
                        
                 
                   }else{
                       return "<span class='badge btn-default' style='width:80px;height:20px'>PENDING</span>";
                   }
                 
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
            ],
        ];
            echo GridView::widget([
                'id' => 'analysis-grid',
                'responsive'=>true,
                'dataProvider'=> $analysisdataprovider,
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'showPageSummary' => true,
                'hover'=>true,
                'columns' => $analysisgridColumns,
                'toolbar' => [
                ],
            ]);
        ?>
    </div>
</div>
</div>

<?php

function stringToSecret(string $string = NULL)
{
    if (!$string) {
        return NULL;
    }
    $length = strlen($string);
    $visibleCount = (int) round($length / 5);
    $hiddenCount = $length - ($visibleCount * 2);
    return substr($string, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
}

?>