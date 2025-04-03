<?php



use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Module List';
$this->params['breadcrumbs'][] = $this->title;
$Buttontemplate='{view}{update}';
?>
<div class="package-index">
    <div class="panel panel-primary col-xs-12">
        <div class="panel-heading"><i class="fa fa-angellist"></i> <?= $this->title ?> View</div>
        <div class="panel-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                //'bordered' => true,
                //'striped' => true,
                //'condensed' => true,
                //'responsive' => true,
                //'hover' => true,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'PackageName',
                        'label' => 'PackageName',
                        'value' => function($model) {
                            return ucwords($model->PackageName);
                        }
                    ],
                    [
                        'attribute' => 'icon',
                        'label' => 'Icon',
                        'format' => 'raw',
                        'value' => function($model) {
                            return "<span class='" . $model->icon . "'><span>";
                        }
                    ],
                    'created_at:date',
                    'updated_at:date',
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => $Buttontemplate,
                        'buttons'=>[
                            'view'=>function ($url, $model) {
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>'/module/'.$model->PackageID, 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Module</font>")]);
                            },
                        'update'=>function ($url, $model) {
                            return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>'/module/update/'.$model->PackageID,'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Module</font>")]);
                        },
                        /*'delete'=>function ($url, $model) {
                          return Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value'=>'/profile/delete/'.$model->profile_id, 'onclick'=>'ConfirmBox(this.title,this.value)', 'class' => 'btn btn-danger']);
                        },
                         * 
                         */
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
        
    </div>
</div>
