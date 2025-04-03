<div class="form-group" id="add-inventory-withdrawaldetails">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'InventoryWithdrawaldetails',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'inventory_withdrawaldetails_id' => ['type' => TabularForm::INPUT_HIDDEN],
        'inventory_withdrawal_id' => [
            'label' => 'Tbl inventory withdrawal',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\inventory\InventoryWithdrawal::find()->orderBy('inventory_withdrawal_id')->asArray()->all(), 'inventory_withdrawal_id', 'inventory_withdrawal_id'),
                'options' => ['placeholder' => 'Choose Tbl inventory withdrawal'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'quantity' => ['type' => TabularForm::INPUT_TEXT],
        'price' => ['type' => TabularForm::INPUT_TEXT],
        'withdarawal_status_id' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowInventoryWithdrawaldetails(' . $key . '); return false;', 'id' => 'inventory-withdrawaldetails-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Tbl Inventory Withdrawaldetails', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowInventoryWithdrawaldetails()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

