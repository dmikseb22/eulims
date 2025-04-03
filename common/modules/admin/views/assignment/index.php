<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignment');
$this->params['breadcrumbs'][] = $this->title;

$func=new Functions();
$Header="Port Management System<br>";
$Header.="List of Assignment";

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    $usernameField,
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
    'class' => 'kartik\grid\ActionColumn',
    'template' => '{view}',
    'buttons' => [
        'view'=>function ($url, $model) {
            return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/admin/assignment/view?id='.$model->user_id, 'onclick'=>'ShowModal(this.title, this.value,true,"760px");', 'class' => 'btn btn-primary','title' => Yii::t('app', "View User</font>")]);
        }
    ]
];
?>
<div class="assignment-index">
    <?= $this->renderFile(__DIR__.'/../menu.php',['button'=>'Assignment']); ?>
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
            'heading' => '<i class="fa fa-user-circle fa-adn"></i> Assignment',
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'exportConfig'=>$func->exportConfig("List of Assignment", "Assignment", $Header),
        'columns' => $columns,
    ]);
    ?>
</div>
