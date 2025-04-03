<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\Functions;
use yii\bootstrap\Modal;
use kartik\dialog\Dialog;
use yii\web\JsExpression;
use yii\widgets\ListView;


$this->title = empty($model->referralCode) ? $model->id : $model->referralCode;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


 $Func="LoadModal('Cancellation of Request','/lab/cancelrequest/create?req=".$model->id."',true,500)";
    $CancelButton='<button id="btnCancel" onclick="'.$Func.'" type="button" style="float: right" class="btn btn-danger"><i class="fa fa-remove"></i> Cancel Request</button>';
?>
<div class="request-view ">
    <div class="container table-responsive">
        <?php
            echo DetailView::widget([
                'model'=>$model,
                'responsive'=>true,
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'panel'=>[
                    'heading'=>'<i class="glyphicon glyphicon-book"></i> Referral Code ' . $model->referralCode,
                    'type'=>DetailView::TYPE_PRIMARY,
                ],
                'buttons1' => '',
                'attributes'=>[
                    [
                        'group'=>true,
                        'label'=>'Referral Details '.$CancelButton,
                        'rowOptions'=>['class'=>'info']
                    ],
                    [
                        'columns' => [
                            [   'attribute'=>'referralCode',
                                'displayOnly'=>true,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'label'=>'Customer / Agency',
                                'format'=>'raw',
                                'value'=> !empty($customer['customer_name']) ? $customer['customer_name'] : "<i class='text-danger font-weight-bold h5'>Hidden - Customer from Referral Network</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'label'=>'Referral Date / Time',
                                'format'=>'raw',
                                'value'=> ($model->referralDate != "0000-00-00 00:00:00") ? Yii::$app->formatter->asDate($model->referralDate, 'php:F j, Y ').$model->referralTime : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Address',
                                'format'=>'raw',
                                'value'=>!empty($customer['address']) ? $customer['address'] : "",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],
                        
                    ],
                    [
                        'columns' => [
                           [
                                'attribute'=>'samplereceivedDate',
                                'label'=>'Sample Received Date',
                                'format'=>'raw',
                                'value'=> !empty($model->samplereceivedDate) ? Yii::$app->formatter->asDate($model->samplereceivedDate, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No sample received date</i>",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Tel no.',
                                'format'=>'raw',
                                'value'=>!empty($customer['tel']) ? $customer['tel'] : "",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'attribute'=>'report_due',
                                'label'=>'Estimated Due Date',
                                'format'=>'raw',
                                'value'=> ($model->reportDue != "0000-00-00 00:00:00") ? Yii::$app->formatter->asDate($model->reportDue, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>",
                                'valueColOptions'=>['style'=>'width:30%'],
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Fax no.',
                                'format'=>'raw',
                                'value'=>!empty($customer['fax']) ? $customer['fax'] : "",
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'label'=>'Referred by',
                                'format'=>'raw',
                                'value'=> !empty($as_receiving) ? $as_receiving : null,
                                'displayOnly'=>true
                            ],
                            [
                                'label'=>'Referred to',
                                'format'=>'raw',
                                'value'=> !empty($as_testing) ? $as_testing : null,
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
                                'attribute'=>'receivedBy', 
                                'format'=>'raw',
                                'displayOnly'=>true,
                                'valueColOptions'=>['style'=>'width:30%']
                            ],
                            [
                                'attribute'=>'conforme',
                                'format'=>'raw',
                                'valueColOptions'=>['style'=>'width:30%'], 
                                'displayOnly'=>true
                            ],
                        ],
                    ],
                ],

            ]);
        
        ?>
    </div>
    <div class="container table-responsive">
        <?php
        echo GridView::widget([
                'id' => 'sample-grid',
                'dataProvider'=> $sampleDataProvider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Samples</h3>',
                    'type'=>'primary',
                    // 'before' => $btnSample.(empty($model->request_ref_num) || empty($data->sample_code) ? '' : Html::button('<i class="glyphicon glyphicon-print"></i> Print Label', ['disabled'=>!$enablePrintLabel, 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/reports/preview?url=/lab/request/printlabel','request_id'=>$model->request_id]) . "';" ,'title'=>'Print Label', 'class' => 'btn btn-success'])).$btnGetSamplecode,
                    'after' => false,
                ],
                'columns' => $sampleGridColumns,
                'toolbar' => [
                    'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Refresh Grid', [Url::to(['request/view','id'=>$model->request_id])], [
                                'class' => 'btn btn-default', 
                                'title' => 'Refresh Grid'
                            ]),
                ],
            ]);
        ?>
    </div>
</div>
    