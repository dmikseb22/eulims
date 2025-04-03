<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\SampleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Samples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sample', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sample_id',
            'referral_id',
            'receiving_agency_id',
            'pstcsample_id',
            'package_id',
            //'package_fee',
            //'sample_type_id',
            //'sample_code',
            //'samplename',
            //'description:ntext',
            //'sampling_date',
            //'remarks',
            //'sample_month',
            //'sample_year',
            //'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
