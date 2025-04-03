<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\BidnotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bidnotifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bidnotification-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bidnotification', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bid_notification_id',
            'referral_id',
            'postedby_agency_id',
            'posted_at',
            'recipient_agency_id',
            //'seen',
            //'seen_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
