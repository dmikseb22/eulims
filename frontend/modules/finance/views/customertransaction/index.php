<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\CustomertransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customertransactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customertransaction-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customertransaction', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $walletdataProvider,
        'filterModel' => $searchWallet,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'customerwallet_id',
            'date',
            'last_update',
            'balance',
            'customer_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        </div>
</div>
</div>
