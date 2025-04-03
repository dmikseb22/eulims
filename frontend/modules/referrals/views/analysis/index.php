<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\AnalysisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Analyses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analysis-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Analysis', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'analysis_id',
            'analysis_type_id',
            'date_analysis',
            'agency_id',
            'pstcanalysis_id',
            //'sample_id',
            //'testname_id',
            //'methodreference_id',
            //'analysis_fee',
            //'cancelled',
            //'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
