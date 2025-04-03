<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\ProcedureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procedures';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="procedure-index">

 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $this->registerJsFile("/js/services/services.js"); ?>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=>  Html::button('<span class="glyphicon glyphicon-plus"></span> Create Procedure', ['value'=>'/lab/procedure/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Procedure")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'procedure_name',
            [
                'attribute' => 'procedure_code',
                'label' => 'Description',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:70%; white-space: normal;'],
                'value' => function($model) {    
                        return $model->procedure_code;
                            },
            ],
            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
            'template' => '{update}',
           
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/procedure/view','id'=>$model->procedure_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Procedure")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/procedure/update','id'=>$model->procedure_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Procedure")]);
                },
                'delete'=>function ($url, $model) {
                    $urls = '/lab/procedure/delete?id='.$model->procedure_id;
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Procedure','data-pjax'=>'0']);
                },
            ],
        ],
        ],
    ]); ?>
</div>
