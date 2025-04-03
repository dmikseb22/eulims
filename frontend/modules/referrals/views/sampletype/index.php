<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\SampletypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sampletypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sampletype-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sampletype', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sampletype_id',
            'sample_type',
            'test_category_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
