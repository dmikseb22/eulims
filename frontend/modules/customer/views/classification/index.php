<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\ClassificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Classifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classification-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Classification', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'classification_id',
            'classification',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
