<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\InventoryWithdrawal */

$this->title = $model->inventory_withdrawal_id;
$this->params['breadcrumbs'][] = ['label' => 'Inventory Withdrawals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-withdrawal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->inventory_withdrawal_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->inventory_withdrawal_id], [
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
            'inventory_withdrawal_id',
            'created_by',
            'withdrawal_datetime',
            'lab_id',
            'total_qty',
            'total_cost',
            'remarks:ntext',
            'inventory_status_id',
        ],
    ]) ?>

</div>
