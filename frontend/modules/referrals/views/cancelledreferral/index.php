<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\CancelledreferralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cancelledreferrals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancelledreferral-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cancelledreferral', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cancelledreferral_id',
            'referral_id',
            'reason',
            'cancel_date',
            'agency_id',
            //'cancelled_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
