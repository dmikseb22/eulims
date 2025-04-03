<?php
use yii\helpers\Url;
return [
    'adminEmail' => 'dostonelab@gmail.com',
    'uploadPath'=>"\web\uploads\user\photo",
    'uploadUrl'=>"/uploads/user/photo/",
    'maskMoneyOptions' => [
        'prefix' => '₱ ',
        'suffix' => '',
        'affixesStay' => true,
        'thousands' => ',',
        'decimal' => '.',
        'precision' => 2, 
        'allowZero' => false,
        'allowNegative' => false,
    ]
];
