<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\models\system\BackupConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('dbManager', 'Configuration');
$this->params['breadcrumbs'][] = ['label' => 'DB Manager', 'url' => ['/dbmanager']];
$this->params['breadcrumbs'][] = $this->title;

$func=new Functions();
$Header="Department of Science and Technology<br>";
$Header.="Backup Configurations";
$TotalItem=$dataProvider->getTotalCount();
if($TotalItem<=0){
    $Button="<button type='button' onclick='LoadModal(\"Create Config\",\"/dbmanager/config/create\")' class=\"btn btn-success\"><i class=\"fa fa-cog-o\"></i> Create Config</button>";
}else{
    $Button="";
}
?>
<div class="backup-config-index">
    <div class="col-md-12" style="margin-left: 5px;padding-right: 25px">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-book"></i>  DB Manager Configurations',
            'before'=>$Button,
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'exportConfig'=>$func->exportConfig("Laboratory Request", "laboratory request", $Header),
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'mysqldump_path',
            'Description:ntext',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}', //{restore}
                'buttons' => [
                    'view' => function ($url, $model){
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/dbmanager/config/view?id=' . $model->backup_config_id, 'onclick' => 'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Config")]);
                    },
                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => '/dbmanager/config/update?id='. $model->backup_config_id ,'onclick' => 'LoadModal(this.title, this.value);', 'class' => 'btn btn-success', 'title' => Yii::t('app', "Update Config")]);
                    }
                ],
            ]
        ],
    ]); ?>
    </div>
</div>
