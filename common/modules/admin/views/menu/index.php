<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\modules\admin\components\Helper;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('rbac-admin', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
$Header="Port Management System<br>";
$Header.="List of Menus";
?>
<div class="menu-index">
    <?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => 'menu']); ?>
    <div class="panel panel-default col-xs-12">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fa fa-user-circle fa-adn"></i> List of Menus',
            'before'=>"<button type='button' onclick='ShowModal(\"New Menu\",\"/admin/menu/create\")' class=\"btn btn-success\"><i class=\"fa fa-book-o\"></i> Create Menu</button>",
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'exportConfig'=>$func->exportConfig("List of Menus", "Rules", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'menuParent.name',
                'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                    'class' => 'form-control', 'id' => null
                ]),
                'label' => Yii::t('rbac-admin', 'Parent'),
            ],
            'route',
            'order',
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => Helper::filterActionColumn(['view','update', 'delete']),
                'buttons' => [
                    'view'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/admin/menu/view?id='.$model->id, 'onclick'=>'ShowModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Menu")]);
                    },
                    'update'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/admin/menu/update?id='.$model->id, 'onclick'=>'ShowModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Menu")]);
                    },
                ]
            ]
        ],
    ]);
    ?>
</div>
