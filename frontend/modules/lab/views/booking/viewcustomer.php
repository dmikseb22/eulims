<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Booking */

$this->title = $model->booking_reference;
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$stat="";
if($model->booking_status == 0){
	$stat="Pending";
}elseif($model->booking_status == 1){
	$stat="Approved";
}else{
	$stat="Cancelled";
}
?>
<div class="booking-view">

    <h2>Reference number <font color="green"><?= $model->booking_reference ?></font></h2>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'scheduled_date',
            'description',
            'date_created',        ],
    ]) ?>
	
	  <?= DetailView::widget([
        'model'=>$model,
        'responsive'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<i class="glyphicon glyphicon-book"></i> Customer Details: ',
            'type'=>DetailView::TYPE_PRIMARY,
        ],
        'buttons1' => '',
        'attributes' => [
            [
                'columns' => [
                    [
                        'label'=>'Customer Name',
                        'format'=>'raw',
                        'value'=>$model->customer ? $model->customer->customer_name : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Contact Number',
                        'format'=>'raw',
                        'value'=>$model->customer ? $model->customer->tel : "",
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
                        'value'=>$model->customer ? $model->customer->email : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Address',
                        'format'=>'raw',
                        'value'=>$model->customer ? $model->customer->address : "",
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
        ],
    ]) ?>
	
<h2>Status</h2>
    <h4><?php echo "Booking is ".$stat; ?></h4>
	<?php if($model->booking_status == 2){
	 echo "Reason: ".$model->reason;	
	}?>
</div>
