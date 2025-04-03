<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Functions;
use frontend\modules\finance\components\billing\BillingFunctions;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Billing */

$this->title = $model->billing_id;
$this->params['breadcrumbs'][] = ['label' => 'Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'invoice_number',
                'label'=>'Bill Invoice #'
            ],
            'customer.customer_name',
            [
                'attribute'=>'soa_number',
                'label'=>'SOA Number'
            ],
            'billing_date',
            'due_date',
            [
                'billing_id',
                'label'=>'Transaction #s',
                'format' => 'raw',
                'value'=>function($model){
                    $BillingFunctions=new BillingFunctions();
                    return $BillingFunctions->GetTransactionnumbers($model->billing_id);
                }
            ],
            [
                'attribute'=>'amount',
                'label'=>'Amount',
                'value'=>function($model){
                    $Func=new Functions();
                    return $Func->pesoSign . number_format($model->amount,2);
                }
            ]
        ],
    ]) ?>
    <div class="row" style="float: right;padding-right: 15px">
        <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
</div>
</div>
