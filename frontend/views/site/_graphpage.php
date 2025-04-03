<?php
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use yii\web\JsExpression;


//var_dump($column);


?>


 <?php
                                                echo Highcharts::widget([
                                                    'id' => 'labColumnChart2',
                                                    'scripts' => [
                                                        'modules/exporting',
                                                        'themes/grid-light',
                                                    ],
                                                    'options' => [
                                                        'title' => [
                                                            'text' => 'Firms Assisted',
                                                        ],
                                                        'xAxis' => [
                                                            'title' => [
                                                                'text' => 'Year'
                                                            ],
                                                           'categories' =>$listYear,
                                                        ],
                                                        'yAxis' => [
                                                            'title' => [
                                                                'text' => 'No of Firms'
                                                            ]
                                                        ],
                                                        'labels' => [
                                                            'items' => [
                                                                [
                                                                    'style' => [
                                                                        'left' => '50px',
                                                                        'top' => '18px',
                                                                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                                                    ],
                                                                ],
                                                            ],
                                                        ],
                                                       'series' => $column
                                                    ]
                                                ]);
                                                ?>



