<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\Equipmentservice */

$this->title = $model->equipmentservice_id;
$this->params['breadcrumbs'][] = ['label' => 'Equipmentservices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipmentservice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->equipmentservice_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->equipmentservice_id], [
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
            'equipmentservice_id',
            'inventory_transactions_id',
            'servicetype_id',
            'requested_by',
            'startdate',
            'enddate',
            'request_status',
            'attachment',
        ],
    ]) ?>

</div>
