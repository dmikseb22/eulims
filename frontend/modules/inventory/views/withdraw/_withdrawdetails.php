<h3>Withdrawal Details</h3>
<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;



    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->inventoryWithdrawaldetails,
        'key' => 'inventory_withdrawaldetails_id'
    ]);

    // $dataProvider = new ActiveDataProvider([
    //         'query' => $model,
    //     ]);

    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'inventory_transactions_id',
            'label' => 'Product',
            'value' => function($model){                   
                $prod =$model->inventoryTransactions->product;
                return $prod->product_name;                
            },
        ],
        [
            'attribute' => 'inventory_withdrawal_id',
            'label' => 'Transaction Date',
            'value' => function($model){                   
                return $model->inventoryWithdrawal->withdrawal_datetime;                
            },
        ],
        [
           'attribute' => 'quantity',   
           'format' => ['decimal', 2],
            'pageSummary' => true  
        ],
        [
           'attribute' => 'price',   
           'format' => ['decimal', 2],
            'pageSummary' => true  
        ],
        
    ];
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'],
        'pjax' => true,
        'beforeHeader' => [
            [
                'options' => ['class' => 'skip-export']
            ]
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'showPageSummary' => true,
        'persistResize' => false,
    ]);
