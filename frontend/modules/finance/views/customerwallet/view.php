<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\grid\ActionColumn;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Customerwallet */

// $this->title = $model->customerwallet_id;
// $this->params['breadcrumbs'][] = ['label' => 'Customerwallets', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerwallet-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'customer.customer_name',
            'balance',
            'date',
            'last_update',            
        ],
    ]) ?>


    <?= GridView::widget([
        'dataProvider' => $transactions,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode('Transactions'),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            [
                'attribute'=>'transactiontype',
                'format'=>'html',
                'value'=>function($data){
                    if($data->transactiontype==0)
                        return "<font class='pull-left' color='green'><i class='fa fa-plus' title='credit'></i> credit</font>";
                    elseif ($data->transactiontype==2) {
                        return "<font class='pull-left' color='green'><i class='fa fa-book' title='initial'></i> initial</font>";
                    }
                    else
                        return "<font class='pull-right' color='red'><i class='fa fa-minus'title='debit'></i> debit</font>";
                },
            ],
            [
                'attribute'=>'amount',
                'format'=>['decimal',2],
                'hAlign'=>'right',
                
            ],
            [
                'attribute'=>'balance',
                'format'=>['decimal',2],
                'hAlign'=>'right',
            ],
            'source'
        ],
    ]); ?>
    <div class="form-group pull-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
