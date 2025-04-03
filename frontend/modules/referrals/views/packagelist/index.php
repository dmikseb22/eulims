<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\PackagelistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Packagelists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packagelist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Packagelist', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'package_id',
            'lab_id',
            'sampletype_id',
            'name',
            'rate',
            //'test_method',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
