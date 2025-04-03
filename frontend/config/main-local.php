<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'fNujcIQqjgVF9V2pR_w_7w4icu_59DMd',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = [
    //    'class' => 'yii\debug\Module',
    //];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'common\modules\gii\Module',
        'generators' => [
        'crud'   => [
            'class'     => 'common\modules\gii\generators\crud\Generator',
            'templates' => ['mycrud' => 'common\modules\gii\generators\crud\Generator\default']
        ]
    ]
    ];
}

return $config;
