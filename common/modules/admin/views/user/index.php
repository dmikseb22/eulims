<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\modules\admin\components\Helper;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
$Header="Port Management System<br>";
$Header.="List of Users";
$dataProvider->pagination->pageSize=8;


?>
<div class="user-index">
    <?= $this->renderFile(__DIR__.'/../menu.php',['button'=>'user']); ?>
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
            'heading' => '<i class="fa fa-user-circle fa-adn"></i> User',
            'before'=>"<button type='button' onclick='ShowModal(\"New User Account\",\"/admin/user/signup\")' class=\"btn btn-success\"><i class=\"fa fa-book-o\"></i> New User Account</button>",
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'exportConfig'=>$func->exportConfig("List of Users", "Users", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            'created_at:date',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 0 ? 'Inactive' : 'Active';
                },
                'filter' => [
                    0 => 'Inactive',
                    10 => 'Active'
                ]
            ],
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => Helper::filterActionColumn(['view','update', 'activate']),
                'buttons' => [
                    'view'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/admin/user/view?id='.$model->user_id, 'onclick'=>'ShowModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View User</font>")]);
                    },
                    'update'=>function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/admin/user/update?id='.$model->user_id, 'onclick'=>'ShowModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update User")]);
                    },
                    'activate' => function($url, $model) {
                        if ($model->status == 10) {//Activated already
                            $options = [
                                'title' => Yii::t('rbac-admin', 'Deactivate'),
                                'aria-label' => Yii::t('rbac-admin', 'Deactivate'),
                                'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to deactivate this user?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class'=>'btn btn-danger'
                            ];
                            $mUrl="/admin/user/deactivate?id=$model->user_id";
                            return Html::a('<span class="glyphicon glyphicon-remove-circle"></span>', $mUrl, $options);
                        }else{
                            $options = [
                                'title' => Yii::t('rbac-admin', 'Activate'),
                                'aria-label' => Yii::t('rbac-admin', 'Activate'),
                                'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class'=>'btn btn-info'
                            ];
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                        }
                    }
                ]
            ]
        ]
    ]);
        ?>
</div>
