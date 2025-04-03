<?php

 $server = "localhost";
 $username = "eulims";
 $password = "eulims";

// $usernamerealtime = "arisro9";
// $passwordrealtime = "qwerty!@#$%";
// $realtimeip = "148.72.202.202";

//  $usernamerealtime = "arisro9";
// $passwordrealtime = "qwerty!@#$%";
// $realtimeip = "148.72.202.202";


return [
    'db'=>[
        'class' => 'yii\db\Connection',  
        'dsn' => 'mysql:host='.$server.';dbname=eulims',
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ],
    'labdb'=>[
        'class' => 'yii\db\Connection',  
       'dsn' => 'mysql:host='.$server.';dbname=eulims_lab',
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ],
    'inventorydb'=>[
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host='.$server.';dbname=eulims_inventory',
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ],
    'financedb'=>[
        'class' => 'yii\db\Connection',  
        'dsn' => 'mysql:host='.$server.';dbname=eulims_finance',
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ],
    'addressdb'=>[
        'class' => 'yii\db\Connection',  
        'dsn' => 'mysql:host='.$server.';dbname=eulims_address',
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ],
    'referraldb'=>[
        'class' => 'yii\db\Connection',  
        'dsn' => 'mysql:host='.$server.';dbname=eulims_referral_lab',
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ],
	
	'messagedb'=>[
        'class' => 'yii\db\Connection',  
        'dsn' => 'mysql:host='.$server.';dbname=eulims_message',
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ],
    

    
    
//    'realtimedb'=>[
//        'class' => 'yii\db\Connection',  
//        'dsn' => 'mysql:host='.$realtimeip.';dbname=eulims_lab',
//        'username' => $usernamerealtime,
//        'password' => $passwordrealtime,
//        'charset' => 'utf8',
//        'tablePrefix' => 'tbl_',
//   ],
    

        'realtimedb'=>[
        'class' => 'yii\db\Connection',  
        'dsn' => 'mysql:host='.$server.';dbname=eulims_lab_realtime',
         'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ],
];
