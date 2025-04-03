<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $checkPackage = ($model->package_id) ? $model->package_id : null;
?>

<div class="analysismethodreference-form">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
            <?php
                $gridColumns = [
					[
						'class' => '\kartik\grid\SerialColumn',
						'headerOptions' => ['class' => 'text-center'],
						'contentOptions' => ['class' => 'text-center','style'=>'max-width:20px;'],
					],
					[
						'class' =>  '\kartik\grid\RadioColumn',
						'radioOptions' => function ($model) use ($checkPackage) {
							return [
								'value' => $model['package_id'],
								'checked' => $model['package_id'] == $checkPackage,
							];
						},
						'name' => 'package_id',
						'showClear' => true,
						'headerOptions' => ['class' => 'text-center'],
						'contentOptions' => ['class' => 'text-center','style'=>'max-width:20px;'],
					],
					[
						'class' => '\kartik\grid\ExpandRowColumn',
						'width' => '50px',
						'value' => function ($model, $key, $index, $column) {
							return GridView::ROW_COLLAPSED;
                            //return GridView::ROW_EXPANDED;
						},
						// uncomment below and comment detail if you need to render via ajax
						'detailUrl'=>Url::to(['/lab/analysisreferral/packagedetail']),
						// 'detail' => function ($model, $key, $index, $column) {
							// return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
						// },
						'headerOptions' => ['class' => 'kartik-sheet-style'],
                        //'headerOptions' => '<span class="far fa-plus-square"></span>',
						'expandOneOnly' => true
					],
					[
						'attribute'=>'name',
						'enableSorting' => false,
						'contentOptions' => ['style'=>'max-width:200px;'],
					],
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Fee',
                        'enableSorting' => false,
                        'value' => function($data){
                            return number_format($data['rate'],2);
                        },
                        'contentOptions' => [
                            'style'=>'text-align:right;max-width:45px;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
				];

				echo GridView::widget([
					'id' => 'package-grid',
					'dataProvider'=> $packageDataProvider,
					//'pjax'=>false,
					'pjax'=>true,
					//'headerRowOptions' => ['class' => 'kartik-sheet-style'],
					//'filterRowOptions' => ['class' => 'kartik-sheet-style'],
					'pjaxSettings' => [
						'options' => [
							'enablePushState' => false,
						]
					],
					'containerOptions'=>[
						'style'=>'overflow:auto; height:250px',
					],
					'floatHeaderOptions' => ['scrollingTop' => true],
					'responsive'=>true,
					'striped'=>true,
					'hover'=>true,
					'bordered' => true,
					'panel' => [
					   'heading'=>'<h3 class="panel-title">Packages</h3>',
					   'type'=>'primary',
					   'before' => '',
					   'after'=>false,
					   //'footer'=>false,
					],
					'columns' => $gridColumns,
					'toolbar' => false,
				]);
            ?>
            </div>
        </div>
    </div>
</div>