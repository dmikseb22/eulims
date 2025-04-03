<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AnalysisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Analyses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analysis-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Analysis', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'analysis_id',
            'date_analysis',
            'rstl_id',
            'pstcanalysis_id',
            'request_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
