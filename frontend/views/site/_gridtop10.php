<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
?>




 

                                    
                                 

                                
                                     <?=
                                    GridView::widget([
                                        'dataProvider' => $dataTop10,
                                        'summary' => "",
                                        'id'=>'gridTop',
                                        // 'filterModel' => $searchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                       //     'year',
                                            'testname',
                                            'testcount',
                                        ],
                                    ]);
                                    ?>
                                    
                                 
                                