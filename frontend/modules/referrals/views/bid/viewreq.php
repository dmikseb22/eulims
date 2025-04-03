<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\ReferralFunctions;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Bid */

?>
<div class="bidreferral-req-view">
<div class="container">
    <?php
		//$component = new ReferralFunctions();
		$rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
		//$checkOwner = $component->checkOwner($referralId,$rstlId);
		
		$sampleGridColumns = [
            [
                'attribute'=>'sample_code',
                'enableSorting' => false,
                'contentOptions' => [
                    'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
				'format' => 'raw',
            ],
            [
                'attribute'=>'sample_name',
                'enableSorting' => false,
				'format' => 'raw',
            ],
            [
                'attribute'=>'description',
                'format' => 'raw',
                'enableSorting' => false,
                //'value' => function($data){
                //    return ($data->referral->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".date("Y-m-d h:i A",strtotime($data->sampling_date))."</b></span>,&nbsp;".$data->description : $data->description;
                //},
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
                //'heading'=>'<h3 class="panel-title">'.$agency->code.' Bid Sample Requirement</h3>',
				'heading' => 'Samples',
                'type'=>'primary',
                'before'=>null,
                'after'=>false,
            ],
            'columns' => $sampleGridColumns,
            'toolbar' => [],
        ]);

        $biddingGridColumns = [
            [
                'header'=>'Sample Requirements',
                'attribute'=>'sample_requirements',
                'enableSorting' => false,
				'format' => 'raw',
                'contentOptions' => [
                    'style'=>'max-width:170px; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
				'value' => function($data) {
				    return nl2br($data['sample_requirements']);
				},
            ],
            [
                'header'=>'Remarks',
                'attribute'=>'remarks',
                'enableSorting' => false,
				'format' => 'raw',
				'value' => function($data) {
				    return nl2br($data['remarks']);
				},
				'contentOptions' => [
                    'style'=>'max-width:170px; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
            ],
    //         [
    //             'attribute'=>'bid_amount',
    //             'format' => 'raw',
    //             'enableSorting' => false,
				// 'contentOptions' => [
    //                 'style'=>'max-width:180px; overflow: auto; white-space: normal; word-wrap: break-word;'
    //             ],
    //         ],
			[
                'header'=>'Estimated Due',
                'attribute'=>'estimated_due',
                'format' => 'raw',
                'enableSorting' => false,
				'contentOptions' => [
                    'style'=>'max-width:30px; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
				'value' => function($data){
				    return date('F j, Y',strtotime($data['estimated_due']));
				},
            ],
        ];

        echo GridView::widget([
            'id' => 'bidding-grid',
            'dataProvider'=> $bidDataProvider,
            'pjax'=>true,
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ]
            ],
            'responsive'=>true,
            'striped'=>true,
            'hover'=>true,
            'showPageSummary' => false,
            'hover'=>true,
            'panel' => [
                'heading'=>'<h3 class="panel-title">'.$agency['code'].' Bid Sample Requirement</h3>',
                'type'=>'primary',
                'before'=> null,
                'after' => false,
            ],
            'columns' => $biddingGridColumns,
            'toolbar' => [],
        ]);
    ?>
		
	<div id="show-testbids">
	<?php			
		$testbidgridColumns = [
            [
                'attribute'=>'sample_name',
                'header'=>'Sample Name',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                'width' => '30%',
				//'value' => function($data){
				//    return $data['sample_name'];
				//},
            ],
            /*[
                'attribute'=>'sample_code',
                'header'=>'Sample Code',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
            ],*/
            [
                'attribute'=>'test_name',
                'format' => 'raw',
                'header'=>'Test/ Calibration Requested',
                'contentOptions' => ['style' => 'width: 15%;word-wrap: break-word;white-space:pre-line;'],
                'enableSorting' => false,
                'width' => '30%',
				//'value' => function($data){
				//    return !empty($data->analysis->testname->test_name) ? $data->analysis->testname->test_name : $data['test_name'];
				//},
            ],
            [
                'attribute'=>'method',
                'format' => 'raw',
                'header'=>'Test Method',
                'enableSorting' => false,  
                'contentOptions' => ['style' => 'width: 50%;word-wrap: break-word;white-space:pre-line;'],
                'pageSummary' => '<span style="float:right";>SUBTOTAL<BR>DISCOUNT<BR><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL</B></span>',
                'width' => '30%',
				//'value' => function($data){
				//    return !empty($data->analysis->methodreference->method) ? $data->analysis->methodreference->method : $data['method'];
				//},
            ],
			[
                'enableSorting' => false,
				'attribute' => 'fee',
				'format' => 'raw',
				'format'=>['decimal', 2],
				'hAlign' => 'right', 
				'vAlign' => 'middle',
				'width' => '10%',
                'pageSummary'=> function () use ($subtotal,$referralId,$discounted,$total,$countBid) {
					if($countBid > 0){
						return  '<div id="subtotal">₱'.number_format($subtotal, 2).'</div><div id="discount">₱'.number_format($discounted, 2).'</div><div id="total"><b>₱'.number_format($total, 2).'</b></div>';
					} else {
                        return '';
                    }
                },
			],
        ];

        echo GridView::widget([
            'id' => 'testbid-grid',
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
                'after' => $checkOwner == 1 && $countBid > 0 ? '<span class="label label-default" style="font-size:13px;">'.$agency['name'].' placed bids.</span>' : '',
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
