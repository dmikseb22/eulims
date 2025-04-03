<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\components\Functions;

/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\BizRule */

$this->title = Yii::t('rbac-admin', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
$Header="Port Management System<br>";
$Header.="List of Rules";
?>
<div class="role-index">
    <?= $this->renderFile(__DIR__ . '/../menu.php', ['button' => 'rule']); ?>
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
                    'heading' => '<i class="fa fa-user-circle fa-adn"></i> List of Rules',
                    'before'=>"<button type='button' onclick='ShowModal(\"New Rule\",\"/admin/rule/create\")' class=\"btn btn-success\"><i class=\"fa fa-book-o\"></i> Create Rule</button>",
                ],
                'pjax' => true, // pjax is set to always true for this demo
                'pjaxSettings' => [
                    'options' => [
                            'enablePushState' => false,
                      ],
                ],
                'exportConfig'=>$func->exportConfig("List of Rules", "Rules", $Header),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'label' => Yii::t('rbac-admin', 'Name'),
                    ],
                    ['class' => 'kartik\grid\ActionColumn',],
                ],
            ]);
            ?>
    </div>
</div>
