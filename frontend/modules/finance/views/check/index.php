<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\CheckSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Checks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
     <?php echo Html::button('<span class="glyphicon glyphicon-check"> </span> Create New Check', ['value' => '/finance/check/create','onclick'=>'ShowModal(this.title,this.value)', 'class' => 'btn btn-success', 'title' => Yii::t('app', "Create Check Details")]); ?>
    </p>
 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'export' => false,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fa fa-check"></i>  Check Details'
            
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'bank',
            'checknumber',
            [
                'attribute'=>'checkdate',
                'label'=>'Check Date',
                'hAlign' => 'right', 
                'pageSummary'=>"Total"
            ],
            [
                'attribute'=>'amount',
                'label'=>'Check Amount',
                'hAlign' => 'right', 
                'format' => ['decimal', 2],
                'pageSummary' => true
            ],
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => "{update}",
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/finance/check/update?id=' . $model->check_id,'onclick'=>'ShowModal(this.title,this.value)', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "Update Check Details")]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
