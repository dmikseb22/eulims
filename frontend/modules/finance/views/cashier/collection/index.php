<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Customer;
use common\models\finance\Collectiontype;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\Op */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\components\Functions;

$func= new Functions();
$this->title = 'Order of Payment';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Cashier', 'url' => ['/finance/cashier']];
$this->params['breadcrumbs'][] = 'Order of Payment';
$this->registerJsFile("/js/finance/finance.js");
$CustomerList= ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name' );

$Header="Department of Science and Technology<br>";
$Header.="Collection";
?>
<div class="orderofpayment-index">
    <?php
        echo $func->GenerateStatusLegend("Legend/Status",true);
    ?>
    
    
  <div class="table-responsive">
    <?php 
    $Buttontemplate='{view}'; 
    ?>
      
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
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                
        ],
        'exportConfig'=>$func->exportConfig("Collection", "collection", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'orderofpayment_id',
           // 'rstl_id',
            'transactionnum',
            [
                'attribute' => 'collectiontype_id',
                'label' => 'Collection Type',
                'value' => function($model) {
                    return $model->collectiontype->natureofcollection;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Collectiontype::find()->asArray()->all(), 'collectiontype_id', 'natureofcollection'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Collection Type', 'id' => 'grid-op-search-collectiontype_id']
            ],
            [
               'attribute'=>'order_date',
               'filterType'=> GridView::FILTER_DATE_RANGE,
               'value' => function($model) {
                    return date_format(date_create($model->order_date),"m/d/Y");
                },
                'filterWidgetOptions' => ([
                     'model'=>$model,
                     'useWithAddon'=>true,
                     'attribute'=>'order_date',
                     'startAttribute'=>'createDateStart',
                     'endAttribute'=>'createDateEnd',
                     'presetDropdown'=>TRUE,
                     'convertFormat'=>TRUE,
                     'pluginOptions'=>[
                         'allowClear' => true,
                        'locale'=>[
                            'format'=>'Y-m-d',
                            'separator'=>' to ',
                        ],
                         'opens'=>'left',
                      ],
                     'pluginEvents'=>[
                        "cancel.daterangepicker" => "function(ev, picker) {
                        picker.element[0].children[1].textContent = '';
                        $(picker.element[0].nextElementSibling).val('').trigger('change');
                        }",
                        
                        'apply.daterangepicker' => 'function(ev, picker) { 
                        var val = picker.startDate.format(picker.locale.format) + picker.locale.separator +
                        picker.endDate.format(picker.locale.format);

                        picker.element[0].children[1].textContent = val;
                        $(picker.element[0].nextElementSibling).val(val);
                        }',
                      ] 
                     
                ]),        
               
            ],
          
            [
                'attribute' => 'customer_id',
                'label' => 'Customer Name',
                'value' => function($model) {
                    return $model->customer ? $model->customer->customer_name : '';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Customer::find()->asArray()->all(), 'customer_id', 'customer_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Customer Name', 'id' => 'grid-op-search-customer_id']
            ],
           
            [
               //'attribute' => 'created_receipt',
               'label'=>'Status', 
               'format'=>'raw',
               'value'=>function($model){
                    $Obj=$model->getCollectionStatus($model->orderofpayment_id);
                    if($Obj){
                       //return "<button class='btn ".$Obj[0]['class']." btn-block'><span class=".$Obj[0]['icon']."></span>".$Obj[0]['payment_status']."</button>"; 
                       return "<span class='badge ".$Obj[0]['class']." legend-font' style='width:80px!important;height:20px!important;'>".$Obj[0]['payment_status']."</span>";
                    }else{
                       //return "<button class='btn btn-primary btn-block'>Unpaid</button>";
                        return "<span class='badge btn-primary legend-font' style='width:80px!important;height:20px!important;'>Unpaid</span>";
                    }
                   //
                },   
                'hAlign'=>'center',
               
            ],
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => $Buttontemplate,
                 'buttons'=>[
                    /*'view'=>function ($url, $model) {
                          return Html::a('View', ['/finance/cashier/view-op?id='.$model->orderofpayment_id], ['target'=>'_blank']);
                    },*/
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/finance/cashier/view-op?id='.$model->orderofpayment_id,'onclick'=>'location.href=this.value', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Collection")]);
                    },        
                  ],
            ],

        ],
    ]); ?>
      
     <?php
    // This section will allow to popup a notification
    $session = Yii::$app->session;
    if ($session->isActive) {
        $session->open();
        if (isset($session['deletepopup'])) {
            $func->CrudAlert("Deleted Successfully","WARNING");
            unset($session['deletepopup']);
            $session->close();
        }
        if (isset($session['updatepopup'])) {
            $func->CrudAlert("Updated Successfully");
            unset($session['updatepopup']);
            $session->close();
        }
        if (isset($session['savepopup'])) {
            $func->CrudAlert("Successfully Saved","SUCCESS",true);
            unset($session['savepopup']);
            $session->close();
        }
        if (isset($session['errorpopup'])) {
            $func->CrudAlert("Transaction Error","ERROR",true);
            unset($session['errorpopup']);
            $session->close();
        }
        if (isset($session['checkpopup'])) {
            $func->CrudAlert("Insufficient Wallet Balance","INFO",true,false,false);
            unset($session['checkpopup']);
            $session->close();
        }
    }
    ?>
  </div>
</div>

