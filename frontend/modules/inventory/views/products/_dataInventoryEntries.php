<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use common\models\inventory\InventoryWithdrawaldetails;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->inventoryEntries,
        'key' => 'inventory_transactions_id'
    ]);
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
                'attribute' => 'suppliers_id',
                'label' => 'Supplier',
                'value' => function($model){                   
                    return $model->suppliers->suppliers;                
                },
        ],
        [
                'attribute' => 'created_at',
                'label' => 'Transaction Date',
                'value' => function($model){                   
                    return date('Y-m-d', ($model->created_at));                
                },
        ],               
         [
             'attribute' => 'content',  
             'value'=>function($model){
                return $model->content." ".$model->product->unittype->unit;
             },
             'pageSummary' => '<span style="float:right;">Total:</span>',
         ],
         // [
         //   'attribute' => 'quantity',
         //   'format' => ['decimal', 2],
         //    'pageSummary' => true  
         // ],
        //  [
        //         'attribute' => 'withdrawdetails',
        //         'label' => 'Withdrawn',
        //         'value' => function($model){  


        //         $withdrawn = InventoryWithdrawaldetails::find()->where(['inventory_transactions_id'=>$model->inventory_transactions_id])->sum('quantity');


        //             return $withdrawn;                
        //         },
        //         'format' => ['decimal', 2],
        //         'pageSummary' => true  

        // ],
        [
           'attribute' => 'quantity_onhand',
           'format' => ['decimal', 2],
            'pageSummary' => true  
         ],
        [
            'header'=>'Total onHand',
            'value'=>function($model){
                return $model->Totalcontent." ".$model->product->unittype->unit;
            },
            'pageSummary' => true 
         ],
         [
           'attribute' => 'amount',   
           'format' => ['decimal', 2],
            'pageSummary' => true  
         ],
         // [
         //   'attribute' => 'total_amount',   
         //   'format' => ['decimal', 2],
         //    'pageSummary' => true  
         // ],
         //  [
         //   'attribute' => 'total_unit',   
         //   'format' => ['decimal', 2],
         //    'pageSummary' => true  
         // ],
    ];
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'],
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
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
