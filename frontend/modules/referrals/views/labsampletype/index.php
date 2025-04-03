<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\LabsampletypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Labsampletypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="labsampletype-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Labsampletype', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'labsampletype_id',
            'lab_id',
            'sampletype_id',
            'date_added',
            'added_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
