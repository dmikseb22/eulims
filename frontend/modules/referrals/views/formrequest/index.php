<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\FormrequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Formrequests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formrequest-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Formrequest', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'formrequest_id',
            'agency_id',
            'title',
            'number',
            'rev_num',
            //'print_format',
            //'rev_date',
            //'logo_left',
            //'logo_right',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
