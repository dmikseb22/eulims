<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Lab;
use common\models\lab\Sampletype;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\DocumentcontrolindexSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Control Index';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentcontrolindex-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
               // 'before'=> Html::button("<span class='glyphicon glyphicon-plus'></span> Create Document Control Form", ["value"=>"/lab/labsampletype/create", "class" => "btn btn-success modal_services","title" => Yii::t("app", "Create New Lab Sample Type")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'documentcontrolindex_id',
            'dcf_no',
            'document_code',
            'title',
           // 'rev_no',
            //'effectivity_date',
            //'dc',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
            'template' => '{view}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/documentcontrolindex/view','id'=>$model->documentcontrolindex_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Document Control Index Form")]);
                },
              
            ],
        ],
        ],
    ]); ?>
   
</div>
