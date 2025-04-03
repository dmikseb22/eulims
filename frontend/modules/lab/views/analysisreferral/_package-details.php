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

<div class="packagetestnamemethodreference-form">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
            <?php
                $gridColumns = [
                    [
                        'header' => 'Testname',
                        'enableSorting' => false,
                        'attribute' => 'testname',
                        /*'value' => function($data){
                            return $data['testname'];
                        },*/
                        'contentOptions' => [
                            'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word; font-size:11px;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'header' => 'Method',
                        'enableSorting' => false,
                        /*'value' => function($data){
                            return $data['method'];
                        },*/
                        'attribute' => 'method',
                        'contentOptions' => [
                            'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word; font-size:11px;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute'=>'reference',
                        'enableSorting' => false,
                        /*'value' => function($data){
                            return $data['reference'];
                        },*/
                        'contentOptions' => [
                            'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word; font-size:11px;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                ];

                echo GridView::widget([
                    'id' => 'testname-method-grid',
                    'dataProvider'=> $testname_methodDataProvider,
                    'pjax'=>true,
                    'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                        ]
                    ],
                    'containerOptions'=>[
                        'style'=>'overflow:auto; height:200px',
                    ],
                    'floatHeaderOptions' => ['scrollingTop' => true],
                    'responsive'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'bordered' => true,
                    'panel' => [
                       'heading'=>'<h3 class="panel-title">Testname & Method Details</h3>',
                       'type'=>'primary',
                       'before' => '',
                       'after'=>false,
                    ],
                    'columns' => $gridColumns,
                    'toolbar' => false,
                ]);
            ?>
            </div>
        </div>
    </div>
</div>