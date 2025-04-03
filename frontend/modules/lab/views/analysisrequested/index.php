<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\AnlysisrequestedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Analysis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analysisrequested-index">

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
                'before'=> Html::button("<span class='glyphicon glyphicon-plus'></span> Create New Analysis", ["value"=>"/lab/analysisrequested/create", "class" => "btn btn-success modal_services","title" => Yii::t("app", "Create New Analysis")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'sample_description',
            'control_no',
            'analysis',
            'price',
            //'total',
            //'joborder_id',
            //'type',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div> 