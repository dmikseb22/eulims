<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;

$this->title = 'Archives';
$this->params['breadcrumbs'][] = $this->title;
$Button="{view}";
?>

<div class="archive-view">
    <section class="invoice">
        <fieldset>
            <legend>Legends - Request Status</legend>
            <div>
                <span class="badge btn-success">Confirmed</span>
                <span class="badge btn-warning">Cancelled </span>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-md-12">
                <div class="request-index">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'containerOptions' => ['style' => 'overflow-x: none!important','class'=>'kv-grid-container'], // only set when $responsive = false
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'rowOptions' => function($model){
                            if($model->status == 'Confirmed'){
                                return ['class'=>'success'];
                            }else{
                                return ['class'=>'danger'];
                            }
                        },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                                'customer',
                                'request_no',
                                'status',
                                'type',
                                'requested_at',
                                [
                                    'class' => kartik\grid\ActionColumn::className(),
                                    'template' => $Button,
                                    'buttons' => [
                                        'view' => function ($url, $model){
                                            return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/services/archive/view?id=' . $model->id,'onclick'=>'window.open(this.value)','target'=>'_blank', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Archive")]);
                                        },
                                    ],
                                ],
                            ],
                        ]); 
                    ?>
                </div>
            </div>
        </div>
    
    </section>
</div>