<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\inventory\CategorytypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Category Type';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorytype-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'before'=>Html::button('<span class="glyphicon glyphicon-plus"></span> Create Category Type', ['value'=>'/inventory/categorytype/create', 'class' => 'btn btn-success','title' => Yii::t('app', "Create New Category Type"),'id'=>'btnCT','onclick'=>'addCT(this.value,this.title)']),
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
         ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'categorytype',
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<script type="text/javascript">
    function addCT(url,title){
        LoadModal(title,url,'true');
    }
  
</script>
