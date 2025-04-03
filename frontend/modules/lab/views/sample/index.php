<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\components\Functions;

$this->title = 'Samples';
$this->params['breadcrumbs'][] = ['label' => 'Lab', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
?>
<div class="sample-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-body">

        <fieldset>
        <legend>Legend/Status</legend>
        <div style='padding: 0 10px'>
			<span class='badge btn-success legend-font'><span class='glyphicon glyphicon-ok'></span> TESTED</span> - Some or All tests are completed.</br>
            <span class='badge btn-warning legend-font'><span class='glyphicon glyphicon-warning-sign'></span> FOR TESTING</span> - No test has been conducted yet.</br>
            <span class='badge btn-danger legend-font'><span class='glyphicon glyphicon-ban-circle'></span>CANCELLED</span> - The Request or Sample is cancelled</br>
            <span class='badge btn-info legend-font'><span class='glyphicon glyphicon-pencil'></span> NOT CODED</span> - This transaction is not finished yet.</br>
        </div>
		</fieldset>

    <?= GridView::widget([
		'id' => 'sample-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
		'panel' => [
			'heading'=>'<h3 class="panel-title">Samples</h3>',
			'type'=>'primary',
			'after'=>false,
		],
        'columns' => [
            [
                'attribute' => 'request_id',
                'format' => 'raw',
                'value' => function($data){ return !empty($data->request->request_ref_num) ? $data->request->request_ref_num : null;},
                'group'=>true,  // enable grouping
				'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'sampletype_id',
                'format' => 'raw',
                'value' => function($data){ return !empty($data->sampletype->type) ? $data->sampletype->type : null;},
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $sampletypes,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Sample Type', 'id' => 'grid-search-sampletype_id'],
				'headerOptions' => ['class' => 'text-center'],
            ],
            [
				'attribute'=>'sample_code',
				'headerOptions' => ['class' => 'text-center'],
			],
			[
				'attribute'=>'samplename',
				'headerOptions' => ['class' => 'text-center'],
			],
            [
                'attribute'=>'description',
                'format' => 'raw',
                'contentOptions' => [
                    'style'=>'max-width:40%; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
				'headerOptions' => ['class' => 'text-center'],
            ],
			[
                'attribute'=>'active',
				'header' => 'Status',
                'format' => 'raw',
				'value' => function($data){
                    if($data->request->status_id == 0){
                        return "<span class='badge btn-danger legend-font'>REQUEST CANCELLED</span>";
                    }
                    if ($data->request->request_ref_num==""){
                        return "<span class='badge btn-info legend-font'>NOT CODED</span>";
                    }
                    if($data->active == 0){
                        return "<span class='badge btn-danger legend-font'>SAMPLE CANCELLED</span>";
                    }

                    if($data->completed == 0){ //temporary fix if 0 its not tested yet
                        return "<span class='badge btn-warning legend-font'>FOR TESTING</span>";
                    }

                    return ($data->active == 1) ? "<span class='badge btn-success legend-font'>TESTED</span>" : "<span class='badge btn-danger legend-font'>SAMPLE CANCELLED</span>";},
				'filterType' => GridView::FILTER_SELECT2,
                'filter' => ['1' => 'Not Cancelled', '0' => 'Cancelled'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Status', 'id' => 'grid-search-active'],
				'contentOptions' => ['class' => 'text-center'],
				'headerOptions' => ['class' => 'text-center'],
            ],
        ],
		'toolbar' => [
			'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', [Url::to([''])], [
						'class' => 'btn btn-default', 
						'title' => 'Reset Grid'
					]),
			//'{toggleData}',
		],
		
    ]); ?>
        </div>
</div>
</div>

<script type="text/javascript">
    $("#modalBtn").click(function(){
        $(".modal-title").html($(this).attr('title'));
        $("#modal").modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
</script>
