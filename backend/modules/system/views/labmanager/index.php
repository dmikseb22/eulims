<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\system\Labrbac;
use common\models\lab\Lab;
use common\components\Functions;
use common\models\system\Rstl;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\LabManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lab Managers';
$this->params['breadcrumbs'][] = $this->title;
$SQL="SELECT user_id, labmanager FROM `vw_labrbac` ORDER BY labmanager";
$Connection= Yii::$app->db;
$Command=$Connection->createCommand($SQL);
$Rows=$Command->queryAll();
$RSTLSQL="SELECT rstl_id, `name` FROM `tbl_rstl` ORDER BY `name`";
$Command2=$Connection->createCommand($RSTLSQL);
$RSTLRows=$Command2->queryAll();
$func=new Functions();
$Header="Department of Science and Technology<br>";
$Header.="Laboratory Manager List";

?>
<div class="lab-manager-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-book"></i>  Request',
            'before'=>"<button type='button' onclick='LoadModal(\"Add Lab Manager\",\"/system/labmanager/create\")' class=\"btn btn-success\"><i class=\"fa fa-book-o\"></i> Add Laboratory Manager</button>",
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'exportConfig'=>$func->exportConfig("Laboratory Request", "laboratory request", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'rstl_id',
                'label' => 'RSTL',
                'value' => function($model) {
                    return $model->rstl ? $model->rstl->name : '';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map($RSTLRows, 'rstl_id', '`name`'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select RSTL'],
            ],
            [
                'attribute' => 'lab_id', 
                'label'=>'Laboratory',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->lab->labname;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Lab::find()->all(), 'lab_id', 'labname'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Laboratory'],
            ],   
            [
                'attribute' => 'user_id', 
                'label'=>'Lab Manager',
                'value' => function ($model, $key, $index, $widget) { 
                    $Manager=Labrbac::find()->where(['user_id'=>$model->user_id])->one();
                    return $Manager ? $Manager->labmanager : '';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map($Rows, 'user_id', 'labmanager'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Manager'],
            ],    
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
