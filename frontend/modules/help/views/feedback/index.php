<?php

use yii\helpers\Html;
use  kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\feedback\UserFeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Feedbacks';

$this->params['breadcrumbs'][] = ['label' => 'Help', 'url' => ['/help']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-feedback-index">
<div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Feedback', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style="overflow: auto;overflow-y: hidden;height:400px"> 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            //'before'=>  Html::button('<span class="glyphicon glyphicon-plus"></span> Create Sample Type Test Name', ['value'=>'/lab/sampletypetestname/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Sample Type Test Name")]),
        ],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

         //   'feedback_id',
            'moduletested',
            'url:ntext',
            'urlpath_screen:ntext',
            'details:ntext',
            'steps:ntext',
             'reported_by',
             'region_reported',
             'action_taken',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
        </div>
</div>
</div>
