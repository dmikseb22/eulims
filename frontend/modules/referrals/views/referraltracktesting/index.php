<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\ReferraltracktestingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Referraltracktestings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referraltracktesting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Referraltracktesting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'referraltracktesting_id',
            'referral_id',
            'testing_agency_id',
            'receiving_agency_id',
            'date_received_courier',
            //'analysis_started',
            //'analysis_completed',
            //'cal_specimen_send_date',
            //'courier_id',
            //'date_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
