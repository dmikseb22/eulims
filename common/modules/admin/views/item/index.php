<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\modules\admin\components\Helper;
use common\modules\admin\components\RouteRule;
use common\modules\admin\components\Configs;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('rbac-admin', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
$func=new Functions();
$Header="Port Management System<br>";
$Header.="List of $labels[Item]s";
$ItemName= strtolower($labels["Item"]);
?>
<div class="role-index">
    <?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => $labels['Items']]); ?>
    <div class="panel panel-default col-xs-12">
        <?php
        $dataProvider->pagination->pageSize=10;
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'bordered' => true,
            'striped' => true,
            'condensed' => true,
            'responsive' => false,
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="fa fa-user-circle fa-adn"></i> List of '.$labels['Item'].'s',
                'before'=>"<button type='button' onclick='ShowModal(\"New $labels[Item]\",\"/admin/$ItemName/create\")' class=\"btn btn-success\"><i class=\"fa fa-book-o\"></i> Create new $labels[Item]</button>",
            ],
            'pjax' => true, // pjax is set to always true for this demo
            'pjaxSettings' => [
                'options' => [
                        'enablePushState' => false,
                  ],
            ],
            'exportConfig'=>$func->exportConfig("List of $labels[Item]s", "$labels[Item]s", $Header),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                    'label' => Yii::t('rbac-admin', 'Name'),
                ],
                [
                    'attribute' => 'ruleName',
                    'label' => Yii::t('rbac-admin', 'Rule Name'),
                    'filter' => $rules
                ],
                [
                    'attribute' => 'description',
                    'label' => Yii::t('rbac-admin', 'Description'),
                ],
                [
                    'class' => kartik\grid\ActionColumn::className(),
                    'template' => Helper::filterActionColumn(['view','update','delete']),
                    //'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'view'=>function ($url, $model) use ($ItemName) {
                            return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>"/admin/$ItemName/view?id=$model->name", 'onclick'=>'ShowModal(this.title, this.value,true,"800px");', 'class' => 'btn btn-primary','title' => Yii::t('app', "View ".ucwords($ItemName))]);
                        },
                        'update'=>function ($url, $model) use ($ItemName) {
                            return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>"/admin/$ItemName/update?id=$model->name", 'onclick'=>'ShowModal(this.title, this.value,true,"800px");', 'class' => 'btn btn-success','title' => Yii::t('app', "Update ".ucwords($ItemName))]);
                        }
                    ]
                ]
            ],
        ])
        ?>
</div>
