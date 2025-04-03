<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\AgencydetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agencydetails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agencydetails-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Agencydetails', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'agencydetails_id',
            'agency_id',
            'name',
            'address',
            'contacts:ntext',
            //'short_name',
            //'lab_name',
            //'labtype_short',
            //'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
