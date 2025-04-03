<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\ReferralFunctions;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Bid */

?>
<div class="row">
    <div class="image-loader" style="display: none;"></div>
    <div class="col-lg-12">
    <?php
		//$component = new ReferralFunctions();
		$rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
		//$checkOwner = $component->checkOwner($referralId,$rstlId);
		
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
                'heading' => '<h3 class="panel-title">Bid</h3>',
                'type' => 'primary',
                'before' => null,
                'after' => false,
            ],
            'columns' => $testbidgridColumns,
            'toolbar' => [],
        ]);
    ?>
    </div>
	</div>
</div>

<style type="text/css">
/* Absolute Center Spinner */
.img-loader {
    position: fixed;
    z-index: 999;
    /*height: 2em;
    width: 2em;*/
    height: 64px;
    width: 64px;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: url('/images/img-loader64.gif');
    background-repeat: no-repeat;
}
/* Transparent Overlay */
.img-loader:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
}
</style>