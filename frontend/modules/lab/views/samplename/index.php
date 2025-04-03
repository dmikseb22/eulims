<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\SampleNameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sample Template';
$this->params['breadcrumbs'][] = ['label' => 'Lab', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-name-index">
    <div class="panel panel-default col-xs-12">
        <div class="panel-heading"><i class="fa fa-adn"></i> </div>
            <div class="panel-body">
            <h1><?php //echo Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?php //echo Html::a('Create Sample Name', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
				'id' => 'samplename-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
				'pjax'=>true,
				'pjaxSettings' => [
					'options' => [
						'enablePushState' => false,
					]
				],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'sample_name_id',
                    'sample_name',
                    //'description',
                    [
                        'attribute'=>'description',
                        'format' => 'raw',
                        //'enableSorting' => false,
                        'contentOptions' => [
                            'style'=>'max-width:40%; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                    ],

                    //['class' => 'yii\grid\ActionColumn'],
					[
						'class' => 'kartik\grid\ActionColumn',
						'template' => '{view} {update} {delete}',
						//'dropdown' => false,
						//'dropdownOptions' => ['class' => 'pull-right'],
						/* 'urlCreator' => function ($action, $model, $key, $index) {
							if ($action === 'delete') {
								$url ='/lab/samplename/delete?id='.$model->sample_name_id;
								return $url;
							}
							if ($action === 'view') {
								$url ='/lab/samplename/view?id='.$model->sample_name_id;
								return $url;
							}
							if ($action === 'update') {
								$url ='/lab/samplename/update?id='.$model->sample_name_id;
								return $url;
							}
						}, */
						'headerOptions' => ['class' => 'kartik-sheet-style'],
						'buttons' => [
							'update' => function ($url, $model) {
								return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', ['class'=>'btn btn-primary','title'=>'Update Sample Template','onclick' => 'updateSamplename('.$model->sample_name_id.')']);
							},
							'delete' => function ($url, $model) {
								return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,['data-confirm'=>"Are you sure you want to delete <b>".$model->sample_name."</b>?",'data-method'=>'post','class'=>'btn btn-danger','title'=>'Delete Sample Template','data-pjax'=>'0']);
							},
							'view' => function ($url, $model) {
								return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', ['class'=>'btn btn-primary','title'=>'View Sample Template','onclick' => 'viewSamplename('.$model->sample_name_id.')']);
							},
						],
					],
                ],
            ]); ?>
            </div>
    </div>
</div>
<script type="text/javascript">
    $('#samplename-grid tbody td').css('cursor', 'pointer');
    function updateSamplename(id){
		var url = '/lab/samplename/update?id='+id;
		$('.modal-title').html('Update Sample Template');
		$('#modal').modal('show')
			.find('#modalContent')
			.load(url);
    }
	function viewSamplename(id){
		var url = '/lab/samplename/view?id='+id;
		$('.modal-title').html('View Sample Template');
		$('#modal').modal('show')
			.find('#modalContent')
			.load(url);
    }
</script>
