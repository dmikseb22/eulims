<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\InventoryEntries */

$this->title = 'Update Inventory Entries: ' . $model->inventory_transactions_id;
$this->params['breadcrumbs'][] = ['label' => 'Inventory Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->inventory_transactions_id, 'url' => ['view', 'id' => $model->inventory_transactions_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inventory-entries-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
