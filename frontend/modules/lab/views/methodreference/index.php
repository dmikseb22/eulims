<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\MethodreferenceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Method References';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="methodreference-index">

<?php $this->registerJsFile("/js/services/services.js"); ?>

   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> Html::button('<span class="glyphicon glyphicon-plus"></span> Create Method Reference', ['value'=>'/lab/methodreference/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Method Reference")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'method',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 30%;word-wrap: break-word;white-space:pre-line;'],
               
            ],
            [
                'attribute'=>'reference',
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 70%;word-wrap: break-word;white-space:pre-line;'],
               
            ],
         //   'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],
         [
            'attribute'=>'fee',
            'format' => 'raw',
            'value' => function($model) {
                return number_format($model->fee, 2);
                },
            'enableSorting' => false,
            'contentOptions' => ['style' => 'width: 70%;word-wrap: break-word;white-space:pre-line;'],
           
        ],
            //'create_time',
            //'update_time',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
          //  'template' => $button,
          'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/methodreference/view','id'=>$model->method_reference_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Method Reference")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/methodreference/update','id'=>$model->method_reference_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Method Reference")]);
                },
                'delete'=>function ($url, $model) {
                    $urls = '/lab/methodreference/delete?id='.$model->method_reference_id;
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Method Reference','data-pjax'=>'0']);
                },
                ],
            ],
        ],
    ]); ?>
</div>
