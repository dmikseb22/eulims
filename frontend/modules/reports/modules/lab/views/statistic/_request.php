<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\widgets\Select2;
//use kartik\widgets\DepDrop;
//use kartik\widgets\DatePicker;
use yii\helpers\Url;
//use yii\web\JsExpression;
//use kartik\widgets\TypeaheadBasic;
//use kartik\widgets\Typeahead;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sample */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="customer-viewrequest">

    <div class="image-loader" style="display: hidden;"></div>

    <div class="row">
        <div class="col-lg-12">
        <?php 
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Customer Name',
                        'format' => 'raw',
                        'value' => function($model) { 
                            return $model->customer_name;
                        },
                        'contentOptions' => ['class'=>'info','style'=>'width:75%;'],
                    ],
                    [
                        'label' => 'Customer Code',
                        'format' => 'raw',
                        'value' => function($model) { 
                            return $model->customer_code;
                        },
                        'contentOptions' => ['class'=>'active','style'=>'width:75%;'],
                    ],
                    [
                        'label' => 'Contact Number',
                        'format' => 'raw',
                        'value' => function($model) { 
                            return $model->tel;
                        },
                        //'headerOptions' => ['class' => 'success'],
                        'contentOptions' => ['class'=>'info','style'=>'width:75%;'],
                    ],
                ],
            ]);
        ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        <?php
            $gridColumns = [
                [
                    'label'=>'Request Reference #',
                    'attribute'=>'request_ref_num',
                    'format'=>'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['class' => 'text-center'],
                    //'value'=>Yii::$app->formatter->asDate($model->request_datetime, 'php:F j, Y'),
                    //'valueColOptions'=>['style'=>'width:30%'], 
                    //'displayOnly'=>true
                    'value' => function($model, $key, $index, $widget){
                        return Html::a($model->request_ref_num, [Url::to(['/lab/request/view','id'=>$model->request_id])], [
                                //'class' => 'btn btn-info', 
                                'class' => 'text-primary', 
                                'title' => 'View Request',
                                'target' => '_self',
                            ]);
                    },
                ],
                [
                    'label'=>'Request Date',
                    'format'=>'raw',
                    //'value'=>Yii::$app->formatter->asDate($model->request_datetime, 'php:F j, Y'),
                    //'valueColOptions'=>['style'=>'width:30%'], 
                    //'displayOnly'=>true
                    'value' => function($model, $key, $index, $widget){
                        return Yii::$app->formatter->asDate($model->request_datetime, 'php:F j, Y');
                    },
                    'enableSorting' => false,
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'attribute'=>'total',
                    'label' => 'Total Income (PHP)',
                    'format' => 'raw',
					'value'=>function ($model, $key, $index, $widget) {
						return Yii::$app->formatter->format($model->total,['decimal',2]);
					},
                    'enableSorting' => false,
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-right'],
                ],
                [
                    'attribute'=>'status_id',
                    'enableSorting' => false,
                    'format'=>'raw',
                    'value' => function($model, $key, $index, $widget){
                        return $model->status->status;
                    },
                    'headerOptions' => ['class' => 'text-center'],
                ],
            ];

            echo GridView::widget([
                'id' => 'customerrequest-grid',
                'dataProvider'=> $dataProvider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'panel' => [
                    'heading'=> "<h5>List of Requests: <b>".$model->customer_name."</b></h5>",
                    'type'=>'info',
                    'before'=>'',
                    'after'=>false,
                ],
                'columns' => $gridColumns,
                'toolbar' => [
                    //'{toggleData}',
                ],
            ]);
        ?>
        </div>
    </div>

</div>