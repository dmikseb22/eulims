<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fees';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $this->registerJsFile("/js/services/services.js"); ?>

<div class="fee-index">

   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> Html::button('<span class="glyphicon glyphicon-plus"></span> Create New Additional Fee', ['value'=>'/lab/sampletype/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Additional Fee")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'code',
            'unit_cost',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
            'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/fee/view','id'=>$model->fee_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Sample Type")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/fee/update','id'=>$model->fee_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Sample Type")]);
                },
                'delete'=>function ($url, $model) {
                    $urls = '/lab/fee/delete?id='.$model->fee_id;
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Sample Type','data-pjax'=>'0']);
                },
            ],
       ],
        ],
    ]); ?>
</div>
