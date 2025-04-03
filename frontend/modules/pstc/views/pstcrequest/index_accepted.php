<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use yii\helpers\Url;
use kartik\date\DatePicker;
use \yii\helpers\ArrayHelper;
use common\models\lab\Customer;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\PstcrequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pstcrequests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pstcrequest-index">

      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'id'=>'pstcrequest-grid',
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> PSTC Request</h3>',
            'type'=>'primary',
            'after'=>false,
            'before'=>'List of PSTC request already accepted.',
        ],
        'columns' => [
            //['class' => 'kartik\grid\SerialColumn'],
            /*[
                'header' => 'Referral Code',
                'attribute' => 'referral_code',
                'format' => 'raw',
                //'value' => function($data){ return $data->referral_code;},
                'headerOptions' => ['class' => 'text-center'],
            ],*/
            [
                'header' => 'Customer Code',
                'attribute' => 'customer_id',
                'format' => 'raw',
                'value' => function($data){ 
                    //return !empty($data->customer) ? $data->customer->customer_name : null;
                    //return Customer::findOne($data['customer_id'])->customer_name;
                    return !empty($data['customer']) ? $data['customer']['customer_code'] : null;
                },
                'headerOptions' => ['class' => 'text-center'],
                /*'filterType' => GridView::FILTER_SELECT2,
                'filter' => $customers,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Search customer name', 'id' => 'grid-search-customer_id'],*/
            ],
            [
                'header' => 'Customer Name',
                'attribute' => 'customer_id',
                'format' => 'raw',
                'value' => function($data){ 
                    //return !empty($data->customer) ? $data->customer->customer_name : null;
                    //return Customer::findOne($data['customer_id'])->customer_name;
                    return !empty($data['customer']) ? $data['customer']['customer_name'] : null;
                },
                'headerOptions' => ['class' => 'text-center'],
                /*'filterType' => GridView::FILTER_SELECT2,
                'filter' => $customers,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Search customer name', 'id' => 'grid-search-customer_id'],*/
            ],
            [
                'header' => 'Date Created',
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function($data){
                    //return Yii::$app->formatter->asDate($data->created_at, 'php:F j, Y h:i A');
                    return date('F j, Y h:i A',strtotime($data['created_at']));
                },
                'headerOptions' => ['class' => 'text-center'],
                /*'filterType'=> GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'model' => $searchModel,
                    'options' => ['placeholder' => 'Select date created'],
                    'attribute' => 'created_at',
                    //'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ],*/
            ],
            [
                'header' => 'Submitted By',
                'attribute' => 'submitted_by',
                'format' => 'raw',
                // 'value' => function($data){
                //     return !empty($data->customer) ? $data->agencyreceiving->name : null;
                // },
                'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'header' => 'Received By',
                'attribute' => 'received_by',
                'format' => 'raw',
                // 'value' => function($data){
                //     return !empty($data->customer) ? $data->agencyreceiving->name : null;
                // },
                'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'dropdown' => false,
                'dropdownOptions' => ['class' => 'pull-right'],
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'buttons' => [
                    'view' => function($url, $data) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['pstcrequest/view','request_id'=>$data['pstc_request_id'],'pstc_id'=>$data['pstc_id']]),'onclick'=>'window.open(this.value,"_blank")', 'class' => 'btn btn-primary','title' => 'View PSTC Request']);
                        //return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['referral/view', 'id' => $data->referral_id], ['class' => 'btn btn-primary','title' => 'View '.$data->referral_code,'target'=>"_blank"]);
                    },
                ],
            ],
        ],
        'toolbar' => [
            'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Refresh Grid', [Url::to(['/pstc/pstcrequest/not_accepted'])], [
                        'class' => 'btn btn-default', 
                        'title' => 'Refresh Grid'
                    ]),
        ],
]); ?>
</div>

<script type="text/javascript">
    $('#pstcrequest-grid tbody td').css('cursor', 'pointer');
    function addRequest(url,title){
        $(".modal-title").html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
</script>