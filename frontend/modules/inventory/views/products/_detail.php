<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model common\models\inventory\Products */

?>
<div class="products-view">

    <div class="row">
         <?= DetailView::widget([
            'model'=>$model,
            'responsive'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
                'heading'=>'<i class="glyphicon glyphicon-book"></i> Product Details',
                'type'=>DetailView::TYPE_PRIMARY,
            ],
            'buttons1' => '',
            'attributes' => [
                [
                    'columns' => [
                        [
                            'label'=>'Product Code',
                            'format'=>'raw',
                            'value'=>$model->product_code,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Product Name',
                            'format'=>'raw',
                            'value'=>$model->product_name,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                    ],

                ],
                [
                    'columns' => [
                        [
                            'label'=>'Category Type',
                            'format'=>'raw',
                            'value'=>$model->categorytype ? $model->categorytype->categorytype : "",
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],
                        [
                            'label'=>'Reorder Point',
                            'format'=>'raw',
                            'value'=>$model->qty_reorder,
                            'valueColOptions'=>['style'=>'width:30%'], 
                            'displayOnly'=>true
                        ],

                    ],

                ],
               // [
               //    'columns' => [
               //        [
               //              'label'=>'Srp',
               //              'format'=>'raw',
               //              'value'=>$model->srp,
               //              'valueColOptions'=>['style'=>'width:30%'], 
               //              'displayOnly'=>true,
               //              'hAlign'=>'left',
               //        ],
               //        [

               //          'label'=>'Price',
               //          'format'=>'raw',
               //          'value'=>$model->price,
               //          'valueColOptions'=>['style'=>'width:30%'], 
               //          'displayOnly'=>true
               //        ],
               //    ],
               // ],
               [
                  'columns' => [
                      // [
                      //       'label'=>'Qty On-hand',
                      //       'format'=>'raw',
                      //       'value'=>$model->qty_onhand,
                      //       'valueColOptions'=>['style'=>'width:30%'], 
                      //       'displayOnly'=>true,
                      //       'hAlign'=>'left',
                      // ],
                      [

                        'label'=>'Description',
                        'format'=>'raw',
                        'value'=>$model->description,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                      ],
                  ],
               ],
              
            ],
        ]) ?>
    </div>
</div>