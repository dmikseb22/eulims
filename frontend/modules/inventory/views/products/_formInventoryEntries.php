<div class="form-group" id="add-inventory-entries">
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
    'formName' => 'InventoryEntries',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'inventory_transactions_id' => ['type' => TabularForm::INPUT_HIDDEN],
        'transaction_type_id' => [
            'label' => 'Transactiontype',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\inventory\Transactiontype::find()->orderBy('transactiontype_id')->asArray()->all(), 'transactiontype_id', 'transactiontype_id'),
                'options' => ['placeholder' => 'Choose Tbl transactiontype'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'rstl_id' => ['type' => TabularForm::INPUT_TEXT],
        'suppliers_id' => [
            'label' => 'Suppliers',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\inventory\Suppliers::find()->orderBy('suppliers_id')->asArray()->all(), 'suppliers_id', 'suppliers_id'),
                'options' => ['placeholder' => 'Choose Tbl suppliers'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'po_number' => ['type' => TabularForm::INPUT_TEXT],
        'quantity' => ['type' => TabularForm::INPUT_TEXT],
        'amount' => ['type' => TabularForm::INPUT_TEXT],
        'total_amount' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowInventoryEntries(' . $key . '); return false;', 'id' => 'inventory-entries-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Inventory Entries', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowInventoryEntries()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>
</div>
