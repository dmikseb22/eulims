<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use kartik\grid\DataColumn;



//echo $count
$this->title = $moduleTitle;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['/reports']];
$this->params['breadcrumbs'][] = ['label' => 'Financial Reports', 'url' => ['/reports/finance/financialreports']];
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
         'toolbar' =>  [
                '{export}',
               
            ],
       // 'filterModel' => $searchModel,
            'columns' => [
                  //  ['class'=>'kartik\grid\SerialColumn'],
                [
                                'attribute' => 'betweenOR',
                                'header' => 'Receipt Date',
                                'group' => true, // enable grouping
                                'groupedRow'=>true,                    // move grouped column to a single grouped row
                                'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                                'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
                              // 'header'=>'OR Series :',
                                'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                                    return [
                                            'mergeColumns'=>[[1,3]], // columns to merge in summary
                                            'content'=>[             // content to show in each summary cell
                                                4=>'Deposits :',
                                                5=>GridView::F_SUM,
                                                6=>GridView::F_SUM,

                                            ],
                                            'contentFormats'=>[      // content reformatting for each summary cell
                                                5=>['format'=>'number', 'decimals'=>2],
                                                6=>['format'=>'number', 'decimals'=>2],

                                            ],
                                            'contentOptions'=>[      // content html attributes for each summary cell
                                               // 1=>['style'=>'font-variant:small-caps'],
                                                4=>['style'=>'text-align:right'],
                                                5=>['style'=>'text-align:right'],
                                                6=>['style'=>'text-align:right'],
                                            ],
                                            // html attributes for group summary row
                                            'options'=>['class'=>'danger','style'=>'font-weight:bold;']
                                        ];
                                    },
                                      
                                    
                                ],
                                 
                                 
                                            
                                
                                    
                                        
                                [
                                'attribute' => 'receiptDate',
                                'header' => 'Receipt Date',

                                ],

                                [
                                    'attribute' =>  'or_number',
                                    'header' => 'Receipt Number',
                                    'subGroupOf'=>0
                                ],
                               [
                                'attribute' => 'payor',
                                'header' => 'Payor',

                                ],
                                 [
                                'attribute' => 'nature',
                                'header' => 'Collection Type',

                                ],
                                 [
                                'attribute' => 'btrAmount',
                                'header' => 'Collection BTR',
                                'contentOptions'=>['style'=>'text-align:right'],

                                ],

                                [
                                'attribute' => 'prjAmount',
                                'header' => 'Collection Project',
                                'contentOptions'=>['style'=>'text-align:right'],
                                ],

                                [
                                'attribute' => 'pmode',
                                'header' => 'Payment Mode',
                                ],
                                [
                                'attribute' => 'checknumber',
                                'header' => 'Check No.',
                                ],


                        
                
                
                
                    ],
    ]); ?>
</div>



