<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\components\Functions;
//use common\models\lab\Customer;
use common\models\lab\CustomerBooking;

$func= new Functions();
$this->title = 'Booking';
$this->params['breadcrumbs'][] = ['label' => 'Calendar', 'url' => ['/lab/booking']];
$this->params['breadcrumbs'][] = 'Manage Booking';
$this->registerJsFile("/js/finance/finance.js");
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\BankaccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="table-responsive">
    <?php 
    $Buttontemplate='{view}'; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
      
        
        'columns' => [
            [
                'attribute' => 'customer_id',
                'label' => 'Customer Name',
                'value' => function($model) {
                    if($model->customer){
                        return $model->customer->customer_name;
                    }else{
                        return "";
                    }
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(CustomerBooking::find()->asArray()->all(), 'customer_booking_id', 'customer_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Customer Name', 'id' => 'grid-op-search-customer_id']
            ],
            'description',
            'qty_sample',
			[
                'attribute' => 'booking_status',
                'label' => 'Status',
                'value' => function($model) {
                    if($model->booking_status == 0){
						return "Pending";
					}elseif($model->booking_status == 1){
						return "Approved";
					}else{
						return "Cancelled";
					}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(CustomerBooking::find()->asArray()->all(), 'customer_booking_id', 'customer_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Customer Name', 'id' => 'grid-op-search-customer_id']
            ],
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => $Buttontemplate,
                'buttons'=>[
					 'view' => function ($url, $model){
						if ($model->booking_status == 1){
							return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/lab/booking/requestview?id=' . $model->booking_id,'onclick'=>'window.open(this.value)','target'=>'_blank', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Request")]);	
						} 
                        else{
							return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => 'view?id=' . $model->booking_id,'onclick'=>'window.open(this.value)','target'=>'_blank', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Booking")]);
						}
                    }
                ]
            ],
        ],
       
    ]); ?>
</div>
