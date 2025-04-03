<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
    // [
    //     'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Products'),
    //     'content' => $this->render('_detail', [
    //         'model' => $model,
    //     ]),
    // ],
        [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Inventory Entries'),
        'content' => $this->render('_dataInventoryEntries', [
            'model' => $model,
            'row' => $model->inventoryEntries,
        ]),
    ],
    //         [
    //     'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Inventory Withdrawaldetails'),
    //     'content' => $this->render('_dataInventoryWithdrawaldetails', [
    //         'model' => $model,
    //         'row' => $model->inventoryEntries->Withdrawdetails?$model->inventoryEntries->Withdrawdetails:"",
    //     ]),
    // ],
        ];
echo TabsX::widget([
    'items' => $items,
    'position' => TabsX::POS_ABOVE,
    'encodeLabels' => false,
    'class' => 'tes',
    'pluginOptions' => [
        'bordered' => true,
        'sideways' => true,
        'enableCache' => false
    ],
]);
?>
