<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\CancelledrequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cancelledrequests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancelledrequest-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cancelledrequest', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'canceledrequest_id',
            'request_id',
            'request_ref_num',
            'reason',
            'cancel_date',
            // 'cancelledby',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        </div>
</div>
</div>
