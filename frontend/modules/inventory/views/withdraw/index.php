<?php

use yii\helpers\Html;
use common\models\lab\Lab;
use kartik\grid\GridView;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\models\inventory\InventoryWithdrawalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventory Withdrawals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-withdrawal-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'before'=>Html::a('Create Inventory Withdrawal', ['out'], ['class' => 'btn btn-success']),
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
         ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('_withdrawdetails', ['model' => $model]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            [
                'attribute' => 'created_by',
                'value' => function($model){     
                    $func = new Functions();              
                    return $func->GetProfileName($model->created_by);                
                },
            ],
            'withdrawal_datetime',
            [
                'attribute'=>'lab_id',
                'value'=> function($model){
                    $lab = Lab::find()->where(['lab_id'=>$model->lab_id])->one();
                    return $lab->labname;
                }
            ],
            'remarks:ntext',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
