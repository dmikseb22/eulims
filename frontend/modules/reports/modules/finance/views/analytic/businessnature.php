<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;


    echo Highcharts::widget([
        'id' => 'yearlyPieChart',
        'scripts' => [
            'modules/exporting',
            'themes/grid-light',
        ],
        'options' => [
            'chart' => [
                'type' => 'pie',
                'height' => '900px'
            ],
            'title' => [
                'text' => 'Customers by Business Nature ' ,
                'style'=>['fontSize'=>'30px']
            ],
            'credits' => false,
            'labels' => [
                'items' => [
                    [
                        'html' => '',
                        'style' => [
                            'left' => '50px',
                            'top' => '18px',
                            'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                        ],
                    ],
                ],
            ],
            'series' => [
                [
                    'name' => 'Total',
                    'data' => $data,
                    'size' => '100%',
                    'showInLegend' => true,
                    'dataLabels' => [
                        'enabled' => false,
                    ],
                ],
            ],
            'legend'=> ['itemStyle'=>['fontSize'=>'25px']]
        ]
    ]);
?>