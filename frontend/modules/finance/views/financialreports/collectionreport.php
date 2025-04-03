<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use kartik\grid\DataColumn;



//echo $count
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Financial Reports', 'url' => ['/finance/financialreports']];
$this->params['breadcrumbs'][] = $moduleTitle;
?>

<style type="text/css">
    .kv-grouped-row {
    background-color: #8CB9E3!important;
    font-size: 1.2em;
    padding-top: 10px!important;
    padding-bottom: 10px!important;
    font-weight: bold;
    font-family: 'Source Sans Pro',sans-serif;
}
</style>



<div class="accountingcode-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
       
    
   
      
        

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'panel'=>['type'=>'primary', 'heading'=>$moduleTitle],
        
//        'beforeHeader'=>
//        [
//                    [
//                        'columns'=>[
//                            ['content'=>'Official', 'options'=>['colspan'=>2, 'class'=>'text-center warning','style'=>'background-color:blue;']], 
//                            ['content'=>'', 'options'=>['colspan'=>4, 'class'=>'text-center warning','style'=>'background-color:blue;']], 
//                            ['content'=>'Amount', 'options'=>['colspan'=>4, 'class'=>'text-center warning','style'=>'background-color:blue;']], 
//                        ],
//                        'options'=>['class'=>'skip-export'] // remove this row from export
//                    ],
//                    [
//                        'columns'=>[
//                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning','style'=>'background-color:blue;']], 
//                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning','style'=>'background-color:blue;']], 
//                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning','style'=>'background-color:blue;']], 
//                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning','style'=>'background-color:blue;']], 
//                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning','style'=>'background-color:blue;']], 
//                           //  ['content'=>'', 'options'=>['colspan'=>3, 'class'=>'text-center warning','style'=>'background-color:blue;']], 
//                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning','style'=>'background-color:blue;']],
//                             ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning','style'=>'background-color:blue;']],
//                            ['content'=>'Breakdown of Collections', 'options'=>['colspan'=>3, 'class'=>'text-center warning','style'=>'background-color:blue;']],
//
//                        ],
//                        'options'=>['class'=>'skip-export'] // remove this row from export
//                    ]
//        ],
       // 'filterModel' => $searchModel,
            'columns' => [
                  //  ['class'=>'kartik\grid\SerialColumn'],
                        
                        [
                        'attribute' => 'receiptDate',
                        'header' => 'Date',

                        ],

                        [
                            'attribute' =>  'or_number',
                            'header' => 'Number',
                            'subGroupOf'=>0
                        ],
                         [
                             'attribute'=>'blankrow', 
                            'header' => 'Responsibility Center Code',
                          
                        ],
                
                                
                       [
                        'attribute' => 'payor',
                        'header' => 'Payor',
                         'width'=>'100px',

                        ],
                         [
                        'attribute' => 'particular',
                        'header' => 'Particulars',

                        ],
                  [
                           
                            'header' => 'MFO/PAP',
                          'attribute'=>'blankrow', 
                        ],
                         [
                        'attribute' => 'btramount',
                        'header' => 'Total per OR ',
                        'contentOptions'=>['style'=>'text-align:right'],
                        'format' => ['decimal', 2],
                        ],
                
                [
                        'attribute' => 'total',
                        'header' => 'Bureau of Treasury',
                      //  'width'=>'5px',
                        'contentOptions'=>['style'=>'vertical-align: bottom;'],
                         'format' => ['decimal', 2],
                        'group' => true, // enable grouping
                       // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                      //  'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                     //   'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
                      // 'header'=>'OR Series :',
//                        'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
//                            return [
//                                    'mergeColumns'=>[[1,3]], // columns to merge in summary
//                                    'content'=>[             // content to show in each summary cell
//                                        4=>'Deposits : ',
//                                        5=>GridView::F_SUM,
//                                        6=>GridView::F_SUM,
//                                        
//                                    ],
//                                    'contentFormats'=>[      // content reformatting for each summary cell
//                                        5=>['format'=>'number', 'decimals'=>2],
//                                        6=>['format'=>'number', 'decimals'=>2],
//                                       
//                                    ],
//                                    'contentOptions'=>[      // content html attributes for each summary cell
//                                       // 1=>['style'=>'font-variant:small-caps'],
//                                        4=>['style'=>'text-align:right'],
//                                        5=>['style'=>'text-align:right'],
//                                        6=>['style'=>'text-align:right'],
//                                    ],
//                                    // html attributes for group summary row
//                                    'options'=>['class'=>'danger','style'=>'font-weight:bold;']
//                                ];
//                            }
                        ],

                        [
                        'attribute' => 'prjAmount',
                        'header' => 'Trust Fund',
                        'contentOptions'=>['style'=>'text-align:right'],
                        
                        'format' => ['decimal', 2],
                       
                        ],
                
                        [
                        'value' => 'deposit_id',
                        'header' => 'Deposit ID',
                        'contentOptions'=>['style'=>'display:none'],
                        ],
                        
//                        [
//                        'attribute' => 'pmode',
//                        'header' => 'Payment Mode',
//                        ],
//                        [
//                        'attribute' => 'checknumber',
//                        'header' => 'Check No.',
//                        ],


                        
                
                
                
                    ],
    ]); ?>
</div>



