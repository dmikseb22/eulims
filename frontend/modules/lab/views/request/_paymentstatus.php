<?php

use common\models\lab\Sample;
use common\models\lab\Testreport;
use common\models\lab\Analysis;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

use common\models\finance\Paymentitem;
use common\models\finance\Op;
use common\models\finance\Receipt;
use common\models\lab\Workflow;
use common\models\lab\Testnamemethod;
use common\models\lab\Methodreference;
use common\models\lab\Request;
use common\models\lab\Procedure;
use common\models\TaggingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use common\models\system\Profile;

?>

<span style="display:inline-block;">



</span>

<?= GridView::widget([
    'dataProvider' => $paymentstatusdataprovider,
    'summary' => '',
    'panel' => [
        'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i>'. $request->request_ref_num.'</h3>',
        'type'=>'primary',
        'items'=>false,
    ],
    'toolbar' => false,
    'columns' => [
        [
            'header'=>'O.R.',
            'hAlign'=>'center',
            'format' => 'raw',
            'enableSorting' => false,
            'value'=> function ($model){
                return "<a href='/finance/cashier/viewreceipt?receiptid=".$model->receipt_id."' target='_blank'>".$model->or_number."</a>";
            },
            'contentOptions' => ['style' => 'width:20%; white-space: normal;'],                   
        ],
        [
            'header'=>'Date',
            'hAlign'=>'center',
            'format' => 'raw',
            'enableSorting' => false,
            'value'=> function ($model){
                return $model->receiptDate;
            },
            'contentOptions' => ['style' => 'width:20%; white-space: normal;'],                   
        ],
        [
            'header'=>'Amount',
            'hAlign'=>'center',
            'format' => 'raw',
            'enableSorting' => false,
            'value'=> function ($model){
                 $orderofpayment = Op::find()->where(['orderofpayment_id' => $model->orderofpayment_id])->one();
                 $paymentitem = Paymentitem::find()->where(['orderofpayment_id' => $orderofpayment->orderofpayment_id])->all();
                 $items = "</br><i>Sub Items</i>";
                 foreach ($paymentitem as $pitem) {
                     $items.= "</br> Request # ".$pitem->details." - Amount of ".$pitem->amount;
                 }
                 return "<b>OR TOTAL AMOUNT ".$model->total."</b>".$items;
            },
            'contentOptions' => ['style' => 'width:60%; white-space: normal;'],                   
        ],

],
]); 


?>