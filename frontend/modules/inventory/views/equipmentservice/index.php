<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\inventory\EquipmentserviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Equipmentservices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipmentservice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Equipmentservice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'equipmentservice_id',
            'inventory_transactions_id',
            'servicetype_id',
            'requested_by',
            'startdate',
            //'enddate',
            //'request_status',
            //'attachment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
