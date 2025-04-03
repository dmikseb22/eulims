<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\Products */

$this->title = $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Products'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'product_id',
        'product_code',
        'product_name',
        'description:ntext',
        'price',
        'srp',
        [
            'attribute' => 'categoryType.categorytype_id',
            'label' => 'Category Type'
        ],
        'qty_reorder',
        'qty_onhand',
        'qty_min_reorder',
        'qty_per_unit',
        'discontinued',
        'suppliers_ids:ntext',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerInventoryEntries->totalCount){
    $gridColumnInventoryEntries = [
        ['class' => 'yii\grid\SerialColumn'],
        'inventory_transactions_id',
        [
                'attribute' => 'transactionType.transactiontype_id',
                'label' => 'Transaction Type'
            ],
        'rstl_id',
        [
                'attribute' => 'suppliers.suppliers_id',
                'label' => 'Suppliers'
            ],
        'po_number',
                'quantity',
        'amount',
        'total_amount',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerInventoryEntries,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Inventory Entries'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnInventoryEntries
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerInventoryWithdrawaldetails->totalCount){
    $gridColumnInventoryWithdrawaldetails = [
        ['class' => 'yii\grid\SerialColumn'],
        'inventory_withdrawaldetails_id',
        [
                'attribute' => 'inventoryWithdrawal.inventory_withdrawal_id',
                'label' => 'Inventory Withdrawal'
            ],
                'quantity',
        'price',
        'withdarawal_status_id',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerInventoryWithdrawaldetails,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Inventory Withdrawaldetails'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnInventoryWithdrawaldetails
    ]);
}
?>
    </div>
</div>
