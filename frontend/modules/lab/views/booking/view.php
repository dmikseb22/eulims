<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use common\components\Functions;
/* @var $this yii\web\View */
/* @var $model common\models\lab\Booking */
$fc = new Functions();
$this->title = $model->booking_id;
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$stat="";
if($model->booking_status == 0){
	$stat="Pending";
	$CancelClass='cancelled-hide';
    $BackClass='';
}elseif($model->booking_status == 1){
	$stat="Approved";
	$CancelClass='cancelled-hide';
    $BackClass='';
}else{
	$stat="Cancelled";
	$CancelClass='request-cancelled';
    $BackClass='background-cancel';
}
?>
<div class="booking-view" style="position:relative;">
	<div id="cancelled-div" class="outer-div <?= $CancelClass ?>">
         <div class="inner-div">
        <img src="/images/cancelled.png" alt="" style="width: 300px;margin-left: 80px"/>
        <div class="panel panel-primary">
            <div class="panel-heading"></div>
            <table class="table table-condensed table-hover table-striped table-responsive">
            
                <tr>
                    <th style="width: 120px;background-color: lightgray">Reason of Cancellation</th>
                    <td style="width: 230px"><?= $model->reason ?></td>
                </tr>
            </table>
        </div>
        </div>
	  </div>	

    <p>
        <?php
		if ($model->booking_status <> 1){
			//echo "&nbsp;&nbsp;";
			if($model->customerstat <> 1){
				echo "&nbsp;&nbsp;";
				echo Html::a('Save as new Customer', ['savecustomer', 'id' => $model->booking_id],['class' => 'btn btn-success']) ;
				$existing="LoadModal('Update Existing Customer','/lab/booking/existingcustomer?id=".$model->booking_id."',true,500)";
				echo $CancelButton='<button id="btnCancel" onclick="'.$existing.'" type="button" style="float: left;padding-right:15px;margin-left: 5px" class="btn btn-primary"><i class="fa fa-pencil"></i> Update Customer</button>';
				echo "&nbsp;&nbsp;";
			}
			else{
				echo "&nbsp;&nbsp;";
				echo Html::a('Save as Request', ['saverequest', 'id' => $model->booking_id], ['class' => 'btn btn-success']);
				$Func="LoadModal('Cancel Booking','/lab/booking/cancelbooking?id=".$model->booking_id."',true,500)";
                echo $CancelButton='<button id="btnCancel" onclick="'.$Func.'" type="button" style="float: left;padding-right:5px;margin-left: 5px" class="btn btn-danger"><i class="fa fa-remove"></i> Disapprove Booking</button>';
			}
			
			
				
		}
		
		?>
        <?php
	//if ($model->customer ? $model->customer->status : 1 != 1) {
		//	echo Html::a('Save as new Customer', ['savecustomer', 'id' => $model->booking_id], ['class' => 'btn btn-success']) ;
	//	}
		
		?>
    </p>
   <div class="<?= $BackClass ?>"></div>
   <div class="container">
	  <?= DetailView::widget([
        'model'=>$model,
        'responsive'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<i class="glyphicon glyphicon-book"></i> Booking Details: '.$stat,
            'type'=>DetailView::TYPE_PRIMARY,
        ],
        'buttons1' => '',
        'attributes' => [
            [
                    'group'=>true,
                    'label'=>'Customer Details ',
                    'rowOptions'=>['class'=>'info']
            ],
            [
                'columns' => [
                    [
                        'label'=>'Customer Name',
                        'format'=>'raw',
                        'value'=>$customer ? $customer->customer_name : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Contact Number',
                        'format'=>'raw',
                        'value'=>$customer ? $customer->tel : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
			[
                'columns' => [
                    [
                        'label'=>'Email',
                        'format'=>'raw',
                        'value'=>$customer ? $customer->email : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Address',
                        'format'=>'raw',
                        'value'=>$customer ? $customer->address : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
			[
                    'group'=>true,
                    'label'=>'Sample booking details ',
                    'rowOptions'=>['class'=>'info']
            ],
			[
                'columns' => [
                    [
                        'label'=>'Scheduled Date',
                        'format'=>'raw',
                        'value'=>$model->scheduled_date,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Booking Reference',
                        'format'=>'raw',
                        'value'=>$model->booking_reference,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
			[
                'columns' => [
                    [
                        'label'=>'Date Created',
                        'format'=>'raw',
                        'value'=>$model->date_created,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Quantity Sample',
                        'format'=>'raw',
                        'value'=>$model->qty_sample,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
			[
                'columns' => [
                    [
                        'label'=>'Sample name',
                        'format'=>'raw',
                        'value'=>$model->samplename,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Decription',
                        'format'=>'raw',
                        'value'=>$model->description,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
        ],
    ]) ?>
	</div>
	
</div>
