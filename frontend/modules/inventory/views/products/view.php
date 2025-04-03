<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\Products */

$this->title = $model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <div class="row">
        <div class="col-sm-3" style="margin-top: 15px">
<?=             
             Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . 'PDF', 
                ['pdf', 'id' => $model->product_id],
                [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => 'Will open the generated PDF file in a new window'
                ]
            )?>
            
            <?= Html::a('Update', ['update', 'id' => $model->product_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->product_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
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
            'label' => 'Category Type',
            'value'=>'categoryType.categorytype'
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
            [
                'attribute' => 'transactionType.transactiontype_id',
                'label' => 'Transaction Type',
                'value'=>'transactionType.transactiontype'
            ],
           
            [
                'attribute' => 'suppliers.suppliers_id',
                'label' => 'Suppliers',
                'value'=>'suppliers.suppliers'
            ],
            'po_number',
                        'quantity',
            'amount',
            'total_amount',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerInventoryEntries,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-tbl-inventory-entries']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Inventory Entries'),
        ],
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
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-tbl-inventory-withdrawaldetails']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Inventory Withdrawaldetails'),
        ],
        'columns' => $gridColumnInventoryWithdrawaldetails
    ]);
}
?>

    </div>
    <div class="row">
        <h4>Categorytype<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnCategorytype = [
        'categorytype_id',
        'categorytype',
        'description:ntext',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
    ?>
</div>
</div>
