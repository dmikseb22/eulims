 <?php

 // use kartik\grid\GridView;
 use yii\grid\GridView;


    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute'=>'testname',
            'enableSorting' => false,
        ],
        [
            'attribute'=>'method',
            'enableSorting' => false,
        ],
       	// [
        //     'attribute'=>'status',
        //     'enableSorting' => false,
        // ],
        [
            'header' => 'Analyst',
            'attribute'=>'user_id',
            'enableSorting' => false,
        ],
            // 'headerOptions' => ['class' => 'kartik-sheet-style'],	
    ];

    echo GridView::widget([
        'id' => 'result-grid',
        'dataProvider'=> $model,
        //'summary' => '',
        //'showPageSummary' => true,
        //'showHeader' => true,
        //'showPageSummary' => true,
        //'showFooter' => true,
        //'template' => '{update} {delete}',
        // 'pjax'=>true,
        // 'pjaxSettings' => [
        //     'options' => [
        //         'enablePushState' => false,
        //     ]
        // ],
        // 'responsive'=>true,
        // 'striped'=>true,
        // 'hover'=>true,
        //'filterModel' => $searchModel,
       // 'toggleDataOptions' => ['minCount' => 10],
        // 'panel' => [
            // 'heading'=>'<h3 class="panel-title">Test Results</h3>',
            // 'type'=>'primary',
        // ],
        // 'rowOptions' => function ($model, $key, $index, $grid) {
        //     return [
                //'id' => $model->sample_id,
                // 'id' => $model->sample_id,
                //'id' => $data['request_id'],
                //'onclick' => 'alert(this.id);',
                // 'onclick' => 'updateSample('.$model->sample_id.');',
                // 'style' => 'cursor:pointer;',
                //'onclick' => 'updateSample(this.id,this.request_id);',
                // [
                //     'data-id' => $model->sample_id,
                //     'data-request_id' => $model->request_id
                // ],
        //     ];
        // },
        'columns' => $gridColumns,
    
    ]);
?>