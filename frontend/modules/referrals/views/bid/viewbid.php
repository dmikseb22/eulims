<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\ReferralFunctions;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Bid */


if($owner == 1){
	$btnSamplereq = "";
} else {
	$btnSamplereq = ($countBid == 0 && !isset($_SESSION['addbid_requirement_'.$referralId]) && $checkOwner == 0 ? Html::button('<span class="glyphicon glyphicon-plus"></span> Add Sample Requirements', ['value'=>Url::to(['/referrals/bid/addbid_requirement','referral_id'=>$referralId]),'onclick'=>'bid(this.value,this.title)','class' => 'btn btn-primary','title' => 'Add Sample Requirements']) : Html::button('<span class="glyphicon glyphicon-eye-open"></span> View your sample requirement', ['value'=>Url::to(['/referrals/bid/viewbid_requirement','referral_id'=>$referralId]),'onclick'=>'bid(this.value,this.title)','class' => 'btn btn-success','title' => 'View your sample requirement'])).'&nbsp;'.($countBid > 0 || !isset($_SESSION['addbid_requirement_'.$referralId]) ? '' : ($checkOwner == 1 ? '' : Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value'=>Url::to(['/referrals/bid/updatebid_requirement','referral_id'=>$referralId]),'onclick'=>'bid(this.value,this.title)','class' => 'btn btn-primary','title' => 'Edit sample requirement'])));
}
?>
<div class="bidreferral-view">
<div class="container">
    <?php
	   $component = new ReferralFunctions();
	   $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
       $checkOwner = $component->checkOwner($referralId,$rstlId);
       $checkBidder = $component->checkBidder($referralId,$rstlId);

        $sampleGridColumns = [
            [
                'attribute'=>'sample_code',
                'enableSorting' => false,
                'contentOptions' => [
                    'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
            ],
            [
                'attribute'=>'sample_name',
                'enableSorting' => false,
            ],
            [
                'attribute'=>'description',
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function($data){
                    return ($data->referral->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".date("Y-m-d h:i A",strtotime($data->sampling_date))."</b></span>,&nbsp;".$data->description : $data->description;
                },
               'contentOptions' => [
                    'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
            ],
        ];

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
                'before'=>null,
                'after'=>false,
            ],
            'columns' => $sampleGridColumns,
            'toolbar' => [],
        ]);
		
        $analysisGridColumns = [
			[
				'class' => 'kartik\grid\SerialColumn',
				'width' => '5%',
			],
            [
                //'attribute'=>'sample_name',
                'header'=>'Sample Name',
				'value'=>function($model){
					return $model->sample->sample_name;
				},
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
				'width' => '30%',
            ],
            /*[
                //'attribute'=>'sample_code',
                'header'=>'Sample Code',
                'format' => 'raw',
				'value'=>function($model){
					return $model->sample->sample_code;
				},
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
            ],*/
            [
                //'attribute'=>'test_name',
				'header'=>'Test Name',
                'format' => 'raw',
                'header'=>'Test/ Calibration Requested',
				'value'=>function($model){
					return $model->testname->test_name;
				},
				'width' => '30%',
                'contentOptions' => ['style' => 'width: 15%;word-wrap: break-word;white-space:pre-line;'],
                'enableSorting' => false,
            ],
            [
                //'attribute'=>'method',
				'header'=>'Method',
                'format' => 'raw',
                'header'=>'Test Method',
				'value'=>function($model){
					return $model->methodreference->method;
				},
				'width' => '30%',
                'enableSorting' => false,  
                'contentOptions' => ['style' => 'width: 50%;word-wrap: break-word;white-space:pre-line;'],         
            ],
			[
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{addfee}',
				'dropdown' => false,
				'dropdownOptions' => ['class' => 'pull-right'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'width' => '5%',
				//'format'=>['decimal', 2],
				'buttons' => [
					'addfee' => function ($url, $data) use ($referralId,$component,$rstlId,$checkOwner) {
						$testbidRefId = 'test_bids_'.$referralId;
						if((isset($_SESSION[$testbidRefId]) && array_key_exists($data->analysis_id,$_SESSION[$testbidRefId]))){
							return 'Done';
						} else {
							$checkTestbid = $component->checkTestbid($referralId,$data->analysis_id,$rstlId);
							if($checkTestbid > 0){
								return 'Done';
							} else {
								return $checkOwner == 1 ? '' : Html::button('<span class="glyphicon glyphicon-plus"></span> Add Fee', ['value'=>Url::to(['/referrals/bid/inserttest_bid','referral_id'=>$referralId,'analysis_id'=>$data->analysis_id]),'onclick'=>'bid(this.value,this.title)','class' => 'btn btn-xs btn-primary','title' => 'Add Fee']);
							}
						}
					},
				],
			],
        ];

        echo GridView::widget([
            'id' => 'analysis-grid',
            'responsive'=>true,
            'dataProvider'=> $analysisDataProvider,
            'pjax'=>true,
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ]
            ],
            'responsive'=>true,
            'striped'=>true,
            'hover'=>true,
            'showPageSummary' => true,
            'hover'=>true,
            
            'panel' => [
                'heading'=>'<h3 class="panel-title">Analysis</h3>',
                'type'=>'primary',
                'before'=> $btnSamplereq,
               'after'=> false,
            ],
            'columns' => $analysisGridColumns,
            'toolbar' => [],
        ]);
    ?>
		
	<div id="show-testbids">
	<?php			
		$testbidgridColumns = [
            [
                //'attribute'=>'sample_name',
                'header'=>'Sample',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                'width' => '30%',
				'value' => function($data){
					return !empty($data->analysis->sample->sample_name) ? $data->analysis->sample->sample_name : $data['sample_name'];
				},
            ],
            /*[
                'attribute'=>'sample_code',
                'header'=>'Sample Code',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
            ],*/
            [
                //'attribute'=>'test_name',
                'format' => 'raw',
                'header'=>'Test/ Calibration Requested',
                'contentOptions' => ['style' => 'width: 15%;word-wrap: break-word;white-space:pre-line;'],
                'enableSorting' => false,
                'width' => '30%',
				'value' => function($data){
					return !empty($data->analysis->testname->test_name) ? $data->analysis->testname->test_name : $data['test_name'];
				},
            ],
            [
                //'attribute'=>'method',
                'format' => 'raw',
                'header'=>'Test Method',
                'enableSorting' => false,  
                'contentOptions' => ['style' => 'width: 50%;word-wrap: break-word;white-space:pre-line;'],
                'pageSummary' => '<span style="float:right";>SUBTOTAL<BR>DISCOUNT<BR><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL</B></span>',
                'width' => '30%',
				'value' => function($data){
					return !empty($data->analysis->methodreference->method) ? $data->analysis->methodreference->method : $data['method'];
				},
            ],
			[
				'class' => 'kartik\grid\EditableColumn',
                'enableSorting' => false,
				'refreshGrid'=>true,
				//'asPopover' => true,
				'attribute' => 'fee',
				'format' => 'raw',
				'readonly' => function($model, $key, $index, $widget) use ($referralId) {
					if(isset($_SESSION['test_bids_'.$referralId])){
						return false;
					} else {
						return true;
					}
				},
				'editableOptions' => [
					'header' => 'Analysis Fee', 
					'size'=>'s',
					'inputType' => \kartik\editable\Editable::INPUT_TEXT,
					'options' => [
						'pluginOptions' => ['min' => 1]
					],
					'name'=>'analysis_fee',
					'placement'  => 'left',
					'formOptions'=>['action' => ['/referrals/bid/update_analysis_fee?referral_id='.$referralId]],
				],
				'format'=>['decimal', 2],
				'hAlign' => 'right', 
				'vAlign' => 'middle',
				'width' => '10%',
                'pageSummary'=> function () use ($subtotal,$referralId,$discounted,$total,$countBid) {
                    $testbidRefId = 'test_bids_'.$referralId;
                    if(isset($_SESSION[$testbidRefId]) && $countBid == 0){
                        return  '<div id="subtotal">₱'.number_format($subtotal, 2).'</div><div id="discount">₱'.number_format($discounted, 2).'</div><div id="total"><b>₱'.number_format($total, 2).'</b></div>';
                    } elseif($countBid > 0){
						return  '<div id="subtotal">₱'.number_format($subtotal, 2).'</div><div id="discount">₱'.number_format($discounted, 2).'</div><div id="total"><b>₱'.number_format($total, 2).'</b></div>';
					} else {
                        return '';
                    }
                },
			],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{remove}',
                'dropdown' => false,
                'dropdownOptions' => ['class' => 'pull-right'],
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'width' => '5%',
                //'format'=>['decimal', 2],
                'buttons' => [
                    'remove' => function ($url, $data) use ($referralId) {
                        $testbidRefId = 'test_bids_'.$referralId;
                        if(isset($_SESSION[$testbidRefId])){
                            return Html::button('<span class="glyphicon glyphicon-remove"></span> Remove', ['value'=>Url::to(['/referrals/bid/remove_testbid','analysis_id'=>$data['analysis_id'],'referral_id'=>$referralId]),'onclick'=>'bid(this.value,this.title)','class' => 'btn btn-xs btn-danger','title' => 'Remove Bid']);
                            //return Html::button('<span class="glyphicon glyphicon-remove"></span> Remove', ['value'=>Url::to(['/referrals/bid/redirect','analysis_id'=>$data['analysis_id'],'referral_id'=>$referralId]),'onclick'=>'updateBid(this.value,this.title)','class' => 'btn btn-xs btn-danger','title' => 'Remove Bid']);
                        } else {
                            return 'Submitted';
                        }
                    },
                ],
            ],
        ];

        echo GridView::widget([
            'id' => 'testbid-grid',
            'responsive'=>true,
            'dataProvider'=> $testbidDataProvider,
            'pjax'=>true,
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ]
            ],
            'responsive'=>true,
            'striped'=>true,
            'hover'=>true,
            'showPageSummary' => true,
            'hover'=>true,
            'panel' => [
                'heading'=>'<h3 class="panel-title">Bid</h3>',
                'type'=>'primary',
                'before'=> null,
                //'after' => $countBid > 0 && $checkOwner == 0 ? '<span class="label label-default" style="font-size:13px;">'.($checkOwner == 0 && $checkBidder == 0 ? 'Already placed bids.' : $agencyCode.' placed bids.').'</span>' : Html::button('<span class="glyphicon glyphicon-check"></span> Place Bid', ['value'=>Url::toRoute(['/referrals/bid/placebid','referral_id'=>$referralId]), 'onclick'=>'bid(this.value,this.title)', 'class' => 'btn btn-primary','title' => 'Place Bid']),
                'after' => $checkOwner == 0 && $countBid > 0 ? ('<span class="label label-default" style="font-size:13px;">'.($checkOwner == 0 && $checkBidder == 1 ? 'Already placed bids.' : $agencyCode.' placed bids.').'</span>') : ($checkOwner == 0 ? Html::button('<span class="glyphicon glyphicon-check"></span> Place Bid', ['value'=>Url::toRoute(['/referrals/bid/placebid','referral_id'=>$referralId]), 'onclick'=>'bid(this.value,this.title)', 'class' => 'btn btn-primary','title' => 'Place Bid']) : ''),
            ],
            'columns' => $testbidgridColumns,
            'toolbar' => [],
        ]);
    ?>
	</div>
</div>
</div>

<script type="text/javascript">
    //placing bid
    function bid(url,title){
        $('.modal-title').html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
</script>
