<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\JoborderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Order';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joborder-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php $this->registerJsFile("/js/services/services.js"); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'hover'=>true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> Html::button("<span class='glyphicon glyphicon-plus'></span> Create New Job Order", ["value"=>"/lab/joborder/create", "class" => "btn btn-success modal_services","title" => Yii::t("app", "Create New Job Order")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'joborder_id',
            'customer_id',
            'joborder_date',
            'sampling_date',
          //  'lsono',
            //'sample_received',

            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => '{view}{update}',
                'buttons' => [     
                    'view' => function ($url, $model){
                        if ( $model->lab==2)
                        {
                            //micro
                            return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/lab/joborder/micro?id=' . $model->joborder_id,'onclick'=>'location.href=this.value', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Job Order")]);
                        }else if ($model->lab==33){
                            //phychem
                            return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/lab/joborder/view?id=' . $model->joborder_id,'onclick'=>'location.href=this.value', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Job Order")]);
                        }else if ($model->lab==34){
                            //phychem
                            return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/lab/joborder/view?id=' . $model->joborder_id,'onclick'=>'location.href=this.value', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Job Order")]);
                        }    
                    },
                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => $model->joborder_id == 2 ? '/lab/request/updatereferral?id='. $model->joborder_id : '/lab/request/update?id='. $model->joborder_id , 'onclick' => 'LoadModal(this.title, this.value);', 'class' => 'btn btn-success', 'title' => $model->joborder_id == 2 ? Yii::t('app', "Update Job Order") : Yii::t('app', "Update Job Order")]);
                    },
                ],
            ],
        ],
    ]); ?>
</div> 