<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\CourierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Couriers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Courier', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'courier_id',
            'name',
            'date_added',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
