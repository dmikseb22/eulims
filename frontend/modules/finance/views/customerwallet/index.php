<?php



use yii\helpers\Html;
// use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use common\models\lab\Customer;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\grid\ActionColumn;


use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\CustomerwalletSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$func= new Functions();
$this->title = 'Customer Wallet';
$this->params['breadcrumbs'][] = $this->title;

$Header="Department of Science and Technology<br>";
$Header.="Customer Wallet";
?>

<div class="customerwallet-index">

<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // 'pjax' => true,
        // 'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'exportConfig'=>$func->exportConfig("Customer Wallet", "customer_wallet", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             // 'customerwallet_id',
            [
                'attribute'=>'customer_id',
                'value'=>'customer.customer_name',
                'filter'=>Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'customer_id',
                    'data' => ArrayHelper::map(Customer::find()->all(), 'customer_id', 'customer_name'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'hideSearch' => false,
                    'options' => [
                        'placeholder' => 'Select a Customer',
                    ]
                ]),
            ],
            [
                'attribute'=>'date',
                'value'=>function($model){
                    return date('d/m/Y H:i:s',strtotime($model->date));
                },
                'filter'=>DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'options' => ['placeholder' => 'Select date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]),
            ],
            [
                'attribute'=>'last_update',
                'value'=>function($model){
                    return date('m-d-Y H:i:s',strtotime($model->last_update));
                },
                'filter'=>DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'last_update',
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'options' => ['placeholder' => 'Select date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]),
            ],
            [
                'attribute'=>'balance',
                'value'=>'balance',
                'filterInputOptions' => [
                    'class' => 'form-control input-sm', 
                    'type' => 'number'
                ],
                // 'filter'=>Html::field($searchModel,'balance')->textInput(['type' => 'number'])->label(false)
            ],
             // ['class' => 'yii\grid\ActionColumn'],
            [ 
                'class' => kartik\grid\ActionColumn::className(),
                'contentOptions' => ['style' => 'width: 8.7%'],
                'visible'=> Yii::$app->user->isGuest ? false : true,
                'template' => '{view}',
                'buttons'=>[
                    'add'=>function ($url, $model) {
                        $CustomerName=$model->customer ? $model->customer->customer_name : '';
                        $t = '/finance/customertransaction/create?customerwallet_id='.$model->customerwallet_id;
                        return Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Add Funds for ".$CustomerName),'name' => Yii::t('app', "Add Funds for <font color='#272727'>[<b>".$CustomerName."</b>]</font>")]);
                    },
                    'view'=>function ($url, $model) {
                        $CustomerName=$model->customer ? $model->customer->customer_name : '';
                        $t = '/finance/customerwallet/view?id='.$model->customerwallet_id;
                        return Html::button('<span class="fa fa-eye"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-primary btn-modal','title' => Yii::t('app', "View History for ".$CustomerName),'name' => Yii::t('app', "View History for  <font color='#272727'>[<b>".$CustomerName."</b>]</font>")]);
                    },
                    
                ],
            ],

        ],
    ]); 



    ?>
	
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
            $func->CrudAlert("Saved Successfully","SUCCESS",true);
            unset($session['savepopup']);
            $session->close();
        }
    }
    ?>
</div>
</div>

