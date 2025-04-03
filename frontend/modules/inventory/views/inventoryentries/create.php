<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\inventory\InventoryEntries */

$this->title = 'Create Inventory Entries';
$this->params['breadcrumbs'][] = ['label' => 'Inventory Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-entries-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
