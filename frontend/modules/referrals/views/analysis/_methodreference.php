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

            <div class="col-md-12">
            <?=
                GridView::widget([
                    'id' => 'method-reference-grid',
                    'dataProvider'=> $methodrefDataProvider,
                    'containerOptions'=>[
                        'style'=>'overflow:auto; height:200px'
                    ],
                    'floatHeaderOptions' => ['scrollingTop' => true],
                    'responsive'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'bordered' => true,
                    'panel' => [
                       'heading'=>'<h3 class="panel-title">Method Reference</h3>',
                       'type'=>'primary',
                       'after'=>false,
                    ],
                    'columns' => [
                        [
                            'class' => '\kartik\grid\SerialColumn',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center','style'=>'max-width:20px;'],
                        ],
                        [
                            'class' =>  '\kartik\grid\RadioColumn',
                            'radioOptions' => function ($model){
                                return [
                                    'value' => $model->id,
                                    'checked' => false,
                                ];
                            },
                            'name' => 'Analysis[methodReference_id]',
                            'showClear' => true,
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center','style'=>'max-width:20px;'],
                        ],
                        [
                            'attribute'=>'method',
                            'contentOptions' => ['class' => 'text-center','style'=>'max-width:30px;white-space:pre-line;'],
                        ],
                        [
                            'attribute'=>'reference',
                            'contentOptions' => ['class' => 'text-center','style'=>'max-width:30px;white-space:pre-line;'],
                        ],
                        [
                            'attribute'=>'fee',
                            'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;'],
                        ],
                        ],
                    'toolbar' => false,
                ]);
            ?>
            </div>
