<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\finance\Client;
use yii\helpers\ArrayHelper;
use common\models\lab\Customer;

/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\clientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance/']];
$this->params['breadcrumbs'][] = ['label' => 'Billing', 'url' => ['/finance/billing/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
            'heading' => '<i class="fa fa-users"></i>  Manage Clients',
            'before'=>Html::a('Add New Client', ['create'], ['title'=>'Add New Client','value'=>'/finance/client/create','class' => 'btn btn-success','onclick'=>'LoadModal(this.title)']),
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'account_number', 
                'label'=>'Account #',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->account_number;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Client::find()->orderBy('account_number')->asArray()->all(), 'account_number', 'account_number'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Account #'],
                'format' => 'raw'
            ],
            [
                'attribute' => 'customer_id', 
                'label'=>'Customer',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->customer ? $model->customer->customer_name : '';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Customer::find()->orderBy('customer_name')->asArray()->all(), 'customer_id', 'customer_name'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Customer'],
                'format' => 'raw'
            ],
            'company_name',
            'signature_date',
            // 'signed',
            // 'active',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>
