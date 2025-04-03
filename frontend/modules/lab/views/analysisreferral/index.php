<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\AnalysisreferralSearch */
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
            'date_analysis',
            'rstl_id',
            'pstcanalysis_id',
            'request_id',
            //'sample_id',
            //'sample_code',
            //'testname',
            //'method',
            //'references',
            //'quantity',
            //'fee',
            //'test_id',
            //'testcategory_id',
            //'sample_type_id',
            //'cancelled',
            //'user_id',
            //'is_package',
            //'type_fee_id',
            //'old_sample_id',
            //'analysis_old_id',
            //'oldColumn_taggingId',
            //'oldColumn_result',
            //'oldColumn_package_count',
            //'oldColumn_requestId',
            //'oldColumn_deleted',
            //'methodreference_id',
            //'testname_id',
            //'old_request_id',
            //'local_analysis_id',
            //'local_sample_id',
            //'local_request_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
