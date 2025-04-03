<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\InventoryEntries */

$this->title = $model->inventory_transactions_id;
$this->params['breadcrumbs'][] = ['label' => 'Inventory Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-entries-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->inventory_transactions_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->inventory_transactions_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'inventory_transactions_id',
            'rstl_id',
            'product_id',
            'manufacturing_date',
            'expiration_date',
            'created_by',
            'suppliers_id',
            'po_number',
            'quantity',
            'amount',
            'total_amount',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
