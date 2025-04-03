<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\TestnamemethodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Testnamemethods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testnamemethod-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Testnamemethod', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'testname_method_id',
            'testname_id',
            'methodreference_id',
            'added_by',
            'create_time',
            //'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
