<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\LabNotebookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lab Notebooks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lab-notebook-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Lab Notebook', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'before'=>Html::button('<span class="glyphicon glyphicon-plus"></span> New Notebook', ['value'=>'/lab/notebook/create', 'class' => 'btn btn-modal btn-success', 'name'=> 'New Notebook', 'title' => Yii::t('app', "Add New Notebook")]),
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'notebook_id',
            'notebook_name',
            'description:ntext',
            'date_created',
            'file',
            [
                'header'=>'Download',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a("<i class='fa fa-download'></i>", ['download','id'=>$model->notebook_id], ['class'=>'btn btn-primary', 'target'=>"_"]);
                }
            ],
            //'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
