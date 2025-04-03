<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\InventoryWithdrawal */

$this->title = 'Update Inventory Withdrawal: ' . $model->inventory_withdrawal_id;
$this->params['breadcrumbs'][] = ['label' => 'Inventory Withdrawals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->inventory_withdrawal_id, 'url' => ['view', 'id' => $model->inventory_withdrawal_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inventory-withdrawal-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
