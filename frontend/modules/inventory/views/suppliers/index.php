<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\inventory\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-index">

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
                'before'=>Html::button('<span class="glyphicon glyphicon-plus"></span> Create Suppliers', ['value'=>'/inventory/suppliers/create', 'class' => 'btn btn-success','title' => Yii::t('app', "Create New Supplier"),'id'=>'btnSupplier','onclick'=>'addSupplier(this.value,this.title)']),
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
         ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'suppliers',
            'description',
            'address',
            'contact_person',
            //'phone_number',
            //'fax_number',
            //'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<script type="text/javascript">
    function addSupplier(url,title){
        LoadModal(title,url,'true');
    }
  
</script>