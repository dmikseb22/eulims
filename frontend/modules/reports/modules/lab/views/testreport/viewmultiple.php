<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testreport */
$mydata=$model->testreports;
$this->title = $model->request->request_ref_num;
$this->params['breadcrumbs'][] = ['label' => 'Batch Testreports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testreport-view">
    <div class="form-row">
        <div class="container table-responsive">
            <button class="btn btn-warning pull-right"><i class="glyphicon glyphicon-check"></i> Reissue Report</button>
        </div>
    </div>
    <br>
    <div class="container table-responsive">
          <?= DetailView::widget([
            'model' => $model,
            'responsive'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
                'heading'=>'<i class="glyphicon glyphicon-book"></i> Request # ' . $model->request->request_ref_num,
                'type'=>DetailView::TYPE_PRIMARY,
            ],	
            'attributes' => [
            	[
            		'label'=>'Request Ref. Number',
            		'attribute'=>'request_id',
                	'value'=>$model->request->request_ref_num
            	],
            	[
            		'label'=>'Request Date / Time',
            		'attribute'=>'request_id',
                	'value'=>date('m-d-Y / H:i A',strtotime($model->request->request_datetime))
            	],
            	[
            		'label'=>'Request Due',
            		'attribute'=>'request_id',
                	'value'=>date('m-d-Y / H:i A',strtotime($model->request->report_due))
            	],
            	[
            		'label'=>'Customer',
            		'attribute'=>'request_id',
                	'value'=>$model->request->customer->customer_name
            	],
            	[
            		'label'=>'Fax',
            		'attribute'=>'request_id',
                	'value'=>$model->request->customer->fax
            	],
            	[
            		'label'=>'Telephone',
            		'attribute'=>'request_id',
                	'value'=>$model->request->customer->tel
            	],
            	[
            		'label'=>'Complete Address',
            		'attribute'=>'request_id',
                	'value'=>$model->request->customer->completeaddress
            	],
                ],
            ]) ?>
    </div>
    <div class="form-row">
    <div class="container table-responsive">
        <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [	
                	'format'=>'raw',
                	'attribute'=>'report_num',
                	'value'=>function($model){
                		$t = 'view?id='.$model->testreport_id;
                		 return Html::a(Html::encode($model->report_num),$t,['target'=>'_blank']);
                	}
                ],
                [
            		'attribute'=>'sample_code',
                	'value'=>function($model){
                		return $model->testreportSamples[0]->sample->sample_code;
                	}
            	],
            	 [
            		// 'header'=>'Samplo',
            		'attribute'=>'sample_name',
                	// 'value'=>$model->testreportSamples[0]->sample_id
                	'value'=>function($model){
                		return $model->testreportSamples[0]->sample->samplename;
                	}
            	],
            ];

            echo GridView::widget([
                'id' => 'sample-grid',
                'dataProvider'=> $mydata,
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i>Test Results with Sample</h3>',
                    'type'=>'primary',
                ],
                'columns' => $gridColumns,
            
            ]);
        ?>
    </div>  
    </div>
    <div class="form-row">
        <div class="container table-responsive">
            <button class="btn btn-success">Print Function</button>
        </div>
    </div>
</div>
