<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\ReferraltrackreceivingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Referraltrackreceivings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referraltrackreceiving-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Referraltrackreceiving', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'referraltrackreceiving_id',
            'referral_id',
            'receiving_agency_id',
            'testing_agency_id',
            'sample_received_date',
            //'courier_id',
            //'shipping_date',
            //'cal_specimen_received_date',
            //'date_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
