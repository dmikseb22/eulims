<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use \yii\helpers\ArrayHelper;
use common\models\system\Rstl;
use kartik\widgets\DatePicker;
use common\models\lab\Lab;
use common\models\lab\Request;
use common\models\lab\ReferralRequest;
use common\components\Functions;
use common\models\lab\Customer; 
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\RequestType;
use common\models\lab\Status;
use yii\bootstrap\Modal;
use common\models\finance\Paymentitem;
use common\models\finance\PaymentStatus;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = ['label' => 'Lab', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
$Header="Department of Science and Technology<br>";
$Header.="Laboratory Request";

$Button="{view}"; 
//get the roles of the current logged user
$roles = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id);
foreach ($roles as $role) {
    //if the user has the role of these two then actioncgridview will not display the specific action buttons 
    if(($role->name == "pro-MANAGER")or($role->name == "super-administrator"))
        $Button="{view}{update}{delete}";
}

$js=<<<JS
    $(document).on('pjax:complete', function() {
        $('#requestsearch-request_datetime').kvDatepicker({
            format : 'yyyy-mm-dd',
            autoclose : true,
            allowClear : true
        });
    });
JS;

$this->registerJs($js,\yii\web\View::POS_READY);

?>
<div class="request-index">  
    <div class="row">
       <!-- <div class="col-sm-3 col-md-3 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-info-circle"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-number">Legends - Report Status</span>    
                    <span class="info-box-number">
                        <span class="badge btn-success">Generated</span>
                        <span class="badge btn-warning">Nearly Due</span>
                        <span class="badge btn-danger">Action Needed</span>
                    </span>
                    
                </div>

            </div>
        </div>
 -->
        <div class="col-sm-3 col-md-3 col-lg-3">
          <!-- small box -->
          <?php if($todaydues) { ?>
            <div class="small-box <?= $todaydues?'bg-yellow':'bg-green'?>">
                <div class="inner">
                  <h3><?=number_format($todaydues,0)?></h3>

                  <p>Due Today (<?= date('d F Y') ?>) </p>
                </div>
                <div class="icon">
                    <?= $todaydues?'<i class="fa fa-exclamation-triangle"></i>':'<i class="fa fa-check-square"></i>'?>
                </div>
                <?= $todaydues?'<a href="/lab/request/more?topic=todaydues" class="small-box-footer">
                  Click to View List <i class="fa fa-arrow-circle-right"></i>
                </a>':'<a class="small-box-footer">
                  All Good
                </a>'?>
            </div> 
          <?php } ?>
          

          <div class="small-box <?= $overdues?'bg-red':'bg-green'?>">
            <div class="inner">
              <h3><?=number_format($overdues,0)?></h3>

              <p>Overdues this year</p>
            </div>
            <div class="icon">
                <?= $overdues?'<i class="fa fa-exclamation-triangle"></i>':'<i class="fa fa-check-square"></i>'?>
            </div>
            <?= $overdues?'<a href="/lab/request/more?topic=overdues" class="small-box-footer">
              Click to View List <i class="fa fa-arrow-circle-right"></i>
            </a>':'<a class="small-box-footer">
              All Good
            </a>'?>
          </div>

        </div> 
        <div class="col-sm-3 col-md-3 col-lg-3">
          <!-- small box -->
          <div class="small-box <?= $unpaids?'bg-red':'bg-green'?>">
            <div class="inner">
              <h3>₱ <?= number_format($unpaids,2)?></h3>

              <p><?= $currentmonth ?> - Worth of Pending Transaction</p>
            </div>
            <div class="icon">
              <?= $unpaids?'<i class="fa fa-exclamation-triangle"></i>':'<i class="fa fa-check-square"></i>'?>
            </div>
            <a class="small-box-footer">
                Search request by payment status below
            </a>
            <!-- <a href="/lab/request/more?topic=unpaid" class="small-box-footer">
              Get More info on Overall <i class="fa fa-arrow-circle-right"></i>
            </a> -->
          </div>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3">
          <!-- small box -->
          <div class="small-box <?= $partials?'bg-red':'bg-green'?>">
            <div class="inner">
              <h3><?= number_format($partials,0)?></h3>

              <p>Partial Payment Transactions in <?= $currentmonth ?></p>
            </div>
            <div class="icon">
              <?= $partials?'<i class="fa fa-exclamation-triangle"></i>':'<i class="fa fa-check-square"></i>'?>
            </div>
            <?= $partials?'<a class="small-box-footer">
                Search request by payment status below
            </a>':'<a class="small-box-footer">
                All Good
            </a>'?>
          </div>
        </div> 

        <div class="col-sm-3 col-md-3 col-lg-3">
          <!-- small box -->
          <div class="small-box <?= $unfinished?'bg-red':'bg-green'?>">
            <div class="inner">
              <h3><?=number_format($unfinished,0)?></h3>

              <p>Unfinished Transaction</p>
            </div>
            <div class="icon">
              <?= $unfinished?'<i class="fa fa-exclamation-triangle"></i>':'<i class="fa fa-check-square"></i>'?>
            </div>
            <?= $unfinished?'<a href="/lab/request/more?topic=unfinished" class="small-box-footer">
              Click to Fix Now <i class="fa fa-arrow-circle-right"></i>
            </a>':'<a class="small-box-footer">
              All Good
            </a>'?>
            
          </div>
        </div>
    </div>
    <div class="table-responsive">
          <?php 
    echo  GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'RequestGrid',
        'filterModel' => $searchModel,
        'containerOptions' => ['style' => 'overflow-x: none!important','class'=>'kv-grid-container'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-book"></i>  Request',
			'before'=>  "<button type='button' onclick='LoadModal(\"Create Request\",\"/lab/request/create\")' class=\"btn btn-success\"><i class=\"fa fa-book-o\"></i> Create Request</button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' value = '/referrals/referral/index' onclick='location.href=this.value' class=\"btn btn-warning\">Referrals</button>&nbsp;&nbsp;&nbsp;<button type='button' value = '/lab/request/notifyreportdue' onclick='location.href=this.value' class=\"btn btn-primary\"><i class=\"glyphicon glyphicon-send\"></i> Notify Report Due</button>
			&nbsp;&nbsp;&nbsp;<button type='button' value = '/pstc/pstcrequest' onclick='location.href=this.value' class=\"btn btn-warning\">PSTC</button>",
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
              
        ],
        'rowOptions' => function($model){
            $stats = Status::findOne($model->status_id);

            //Bergel Cutara, Sr. srs
            //Description : returns the status of the request which defines what css the row appear on the cgridview 

            //the sequence how the code is written is base on the superiority of the status
            //STATUS: report Generated
            if($model->testreports)
                return ['class'=>'success'];
            //STATUS : report nearly due
            $date1=date_create(date('Y-m-d'));
            $date2=date_create($model->report_due);
            $diff=date_diff($date1,$date2);

            if($date2 <= $date1)
                return ['class'=>'danger'];

            if((int)$diff->format('%a') < 4)
                return ['class'=>'warning']; 
 
            //return whatever the status_id the request has
            // return ['class'=>$stats->class];
        },
        'exportConfig'=>$func->exportConfig("Laboratory Request", "laboratory request", $Header),
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            ['attribute'=>'request_ref_num',
             'width' => '180px',
            ],
            [
                'label'=>'Request Date',
                'attribute'=>'request_datetime',
                'width' => '180px',
                'value'=>function($model){
                    //return date('d/m/Y H:i:s',strtotime($model->request_datetime));
                    return ($model->request_type_id == 2 && $model->request_datetime == '0000-00-00 00:00:00') ? null : date('d/m/Y H:i:s',strtotime($model->request_datetime));
                },
                'filter'=>DatePicker::widget([
                    'attribute'=>'request_datetime',
                    'model' => $searchModel,
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose'=>true,
                        'allowClear' => true
                    ]
                ]),
            ],
            [
                'attribute' => 'customer_id', 
                'label'=>'Customer',
                'vAlign' => 'middle',
                'width' => '400px',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) { 

                    if($model->request_type_id==1){
                        return $model->customer ? $model->customer->customer_name : "";                        
                    }

                    $refreq = ReferralRequest::find()->where(['request_id'=>$model->request_id,'receiving_agency_id'=>$model->rstl_id])->one();
                    if($refreq){
                        return $model->customer ? $model->customer->customer_name : "";
                    }
                    return "Customer origin is from the referral";
                },
              
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Customer::find()->orderBy('customer_name')->asArray()->all(), 'customer_id', 'customer_name'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Customer'],
                'contentOptions' => ['style' => 'width: 50%;word-wrap: break-word;white-space:pre-line;'],
            ],
            [
                'label'=>'Total',
                'attribute'=>'total',
                'width' => '100px',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
               
            ],
            [
                'label'=>'Report Due',
                'attribute'=>'report_due',
                'width' => '100px',
                'hAlign'=>'center'
            ],
            [
                'label'=>'Analyses Status',
                'attribute'=>'status_id',
                'hAlign'=>'center',
                'format'=>'raw',
                'width' => '110px',
                'value'=>function($model){
                    if($model->status_id==0)
                        return Html::button('<span"><b>CANCELLED</span>', ['class' => 'btn btn-warning', 'style'=>'width:110px;']);

                    $samples_count= Analysis::find()
                    ->leftJoin('tbl_sample', 'tbl_sample.sample_id=tbl_analysis.sample_id')
                    ->leftJoin('tbl_request', 'tbl_request.request_id=tbl_sample.request_id')
                    ->leftJoin('tbl_tagging', 'tbl_analysis.analysis_id=tbl_tagging.analysis_id')   
                    ->where(['tbl_request.request_id'=>$model->request_id ])
                    ->andWhere(['<>','tbl_analysis.references', '-'])
                    ->all();              
                    $sampletagged= Analysis::find()
                    ->leftJoin('tbl_sample', 'tbl_sample.sample_id=tbl_analysis.sample_id')
                    ->leftJoin('tbl_tagging', 'tbl_analysis.analysis_id=tbl_tagging.analysis_id') 
                    ->leftJoin('tbl_request', 'tbl_request.request_id=tbl_analysis.request_id')    
                    ->where(['tbl_tagging.tagging_status_id'=>2, 'tbl_request.request_id'=>$model->request_id ])
                    ->andWhere(['<>','tbl_analysis.references', '-'])
                    ->all();

                    $samples_pretagged= Analysis::find()
                    ->leftJoin('tbl_sample', 'tbl_sample.sample_id=tbl_analysis.sample_id')
                    ->leftJoin('tbl_request', 'tbl_request.request_id=tbl_sample.request_id')
                    ->innerJoin('tbl_tagging', 'tbl_analysis.analysis_id=tbl_tagging.analysis_id')   
                    ->where(['tbl_request.request_id'=>$model->request_id ])
                    ->andWhere(['<>','tbl_analysis.references', '-'])
                    ->all(); 


                    $scount = count($samples_count); 
                    $rcount = count($sampletagged); 
                    $precount = count($samples_pretagged);
                    if ($precount==0){
                        return Html::button('<span"><b>PENDING</span>', ['value'=>Url::to(['/lab/tagging/samplestatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 1200);', 'class' => 'btn btn-default','title' => Yii::t('app', "Analyses Monitoring"), 'style'=>'width:110px;']);
                        
                    }elseif ($scount>$rcount){
                        return Html::button('<span"><b>ONGOING</span>', ['value'=>Url::to(['/lab/tagging/samplestatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 1200);', 'class' => 'btn btn-primary','title' => Yii::t('app', "Analyses Monitoring"), 'style'=>'width:110px']);
                        
                    }elseif ($scount==$rcount){
                        return Html::button('<span"><b>COMPLETED</span>', ['value'=>Url::to(['/lab/tagging/samplestatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 1200);', 'class' => 'btn btn-success','title' => Yii::t('app', "Analyses Monitoring"), 'style'=>'width:110px']);                  
                    }           
              }
            ],
            [
                'label'=>'Report Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'width' => '100px',
                'value'=>function($model){
                    if($model->status_id==0)
                        return Html::button('<span"><b>CANCELLED</span>', ['class' => 'btn btn-warning', 'style'=>'width:110px;']);

                    if($model->testreports){
                        $req = Request::findOne($model->request_id);
                        //return "<a class='badge badge-success' href='/reports/lab/testreport/view?id=".$req->testreports[0]->testreport_id."' style='width:80px!important;height:20px!important;'>View</a>";
                        return Html::button('<span"><b>VIEW</span>', ['value'=>Url::to(['/lab/request/reportstatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 500);', 'class' => 'btn btn-success','title' => Yii::t('app', "Report Status"), 'style'=>'width:100px']);
                    }else{
                        //STATUS : report nearly due
                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create($model->report_due);
                        $diff=date_diff($date1,$date2);

                        if($date2 <= $date1)
                            return Html::button('<span"><b>NONE</span>', ['value'=>Url::to(['/lab/request/reportstatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 500);', 'class' => 'btn btn-danger','title' => Yii::t('app', "Report Status"), 'style'=>'width:100px']);

                        if((int)$diff->format('%a') < 4)
                            return Html::button('<span"><b>NONE</span>', ['value'=>Url::to(['/lab/request/reportstatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 500);', 'class' => 'btn btn-warning','title' => Yii::t('app', "Report Status"), 'style'=>'width:100px']);

                        return Html::button('<span"><b>NONE</span>', ['value'=>Url::to(['/lab/request/reportstatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 500);', 'class' => 'btn btn-default','title' => Yii::t('app', "Report Status"), 'style'=>'width:100px']);
                    }
                    
                }
            ],
            [
                'attribute' => 'payment_status_id',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(PaymentStatus::find()->orderBy('payment_status ASC')->asArray()->all(), 'payment_status_id', 'payment_status'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Status','id' => 'grid-search-payment-status'],
                'hAlign'=>'center',
                'format'=>'raw',
                // 'width' => '100px',
                'value'=>function($model){
                    if($model->status_id==0)
                        return Html::button('<span"><b>CANCELLED</span>', ['class' => 'btn btn-warning', 'style'=>'width:110px;']);

                    if($model->payment_type_id==2)
                        return Html::button('<span><b>GRATIS</span>', ['value'=>Url::to(['/lab/request/paymentstatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 500);', 'class' => 'btn btn-success','title' => Yii::t('app', "Payment Status"), 'style'=>'width:100px']);
                    
                    if ($model->payment_status_id==2)
                    {
                        return Html::button('<span"><b>PAID</span>', ['value'=>Url::to(['/lab/request/paymentstatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 900);', 'class' => 'btn btn-success','title' => Yii::t('app', "Payment Status"), 'style'=>'width:100px']);
                    }elseif($model->payment_status_id==3){
                        return Html::button('<span"><b>PARTIAL</span>', ['value'=>Url::to(['/lab/request/paymentstatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 500);', 'class' => 'btn btn-warning','title' => Yii::t('app', "Payment Status"), 'style'=>'width:100px']);
                    }else{
                        $label = "PENDING";
                        $class = 'btn btn-default';
                        if($model->discount == '100' or $model->discount_id == 8 ){
                            $label = "GRATIS";
                            $class="btn btn-success";
                        }elseif($model->total==0){
                            $label = "SLT";
                            $class="btn btn-success";
                        }
                        return Html::button('<span><b>'.$label.'</span>', ['value'=>Url::to(['/lab/request/paymentstatus','id'=>$model->request_id]),'onclick'=>'LoadModal(this.title, this.value, true, 500);', 'class' => $class,'title' => Yii::t('app', "Payment Status"), 'style'=>'width:100px']);
                    }
                },
            ],
            // [
            //     'attribute' => 'request_type_id', 
            //     'label'=>'Request Type',
            //     'vAlign' => 'middle',
            //     'value' => function ($model, $key, $index, $widget) { 
            //        return !empty($model->requesttype) ? $model->requesttype->request_type : "";
            //     },
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filter' => ArrayHelper::map(RequestType::find()->asArray()->all(), 'request_type_id', 'request_type'), 
            //     'format' => 'raw',
            //     'width' => '20px',
            //     'filterWidgetOptions' => [
            //         'pluginOptions' => ['allowClear' => true],
            //     ],
            //     'filterInputOptions' => ['placeholder' => 'Select Type','id' => 'grid-search-request_type_id'],
            //     'contentOptions' => ['class' => 'text-center','style'=>'width: 50%;'],
            //     'headerOptions' => ['class' => 'text-center'],
            // ],
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => $Button,
                'buttons' => [
                    
                    'view' => function ($url, $model){
                        if($model->request_type_id==1)
                            return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/lab/request/view?id=' . $model->request_id,'onclick'=>'window.open(this.value)','target'=>'_blank', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Request")]);
                        else{
                            if(isset($_SESSION['usertoken'])){
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/lab/request/view?id=' . $model->request_id,'onclick'=>'window.open(this.value)','target'=>'_blank', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Referral")]);
                            }else{
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/lab/request/view?id=' . $model->request_id,'onclick'=>'','target'=>'_blank', 'class' => 'btn btn-warning', 'title' => Yii::t('app', "Can't View Referral, Please Login! ")]);
                            }
                        }

                    },
                    'update' => function ($url, $model) {

                        if($model->status_id==0)
                        return '';

                        return (!empty($model->request_ref_num) && $model->request_type_id == 2) ? '' : (Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => $model->request_type_id == 2 ? '/lab/request/updatereferral?id='. $model->request_id : '/lab/request/update?id='. $model->request_id , 'onclick' => 'LoadModal(this.title, this.value);', 'class' => 'btn btn-success', 'title' => $model->request_type_id == 2 ? Yii::t('app', "Update Referral Request") : Yii::t('app', "Update Request")]));
                    },
                    'delete' => function ($url, $model) { //Cancel
                        if(($model->status_id==0) || $model->request_type_id == 2) {
                            return '';
                        } else {
                            if($model->IsRequestHasOP()){
                                if($model->IsRequestHasReceipt()){
                                    return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['value' => '/lab/cancelrequest/create?req=' . $model->request_id,'onclick' => 'LoadModal(this.title, this.value,true,"420px");', 'class' => 'btn btn-danger', 'title' => Yii::t('app', "Cancel Request")]);
                                }else{
                                    return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['class' => 'btn btn-danger','disabled'=>true, 'title' => Yii::t('app', "Cancel Request")]);
                                }
                            }else{
                                return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['value' => '/lab/cancelrequest/create?req=' . $model->request_id,'onclick' => 'LoadModal(this.title, this.value,true,"420px");', 'class' => 'btn btn-danger', 'title' => Yii::t('app', "Cancel Request")]);
                            }
                        }
                    }
                ],
            ],
        ],
]); 
?>  
</div>

</div>
