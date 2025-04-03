<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\BillingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Billings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Billing', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'billing_id',
            'invoice_number',
            'user_id',
            'customer_id',
            'soa_number',
            // 'billing_date',
            // 'due_date',
            // 'receipt_id',
            // 'amount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        </div>
</div>
</div>
