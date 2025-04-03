<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
?>




 

                                    
                     
                                    
                                 
                                    <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'id'=>'sampleTop',
                                    'summary'=>"", 
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        'samplename',
                                        [
                                            'header' => 'Count',
                                            'contentOptions' => ['class' => 'text-left'],
                                            'attribute' => 'package_rate',
                                        ],
                                    ],
                                ]); ?>