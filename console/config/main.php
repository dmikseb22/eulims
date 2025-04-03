<?php
/*$params = array_merge(
    //require __DIR__ . '/../../common/config/params.php',
    //require __DIR__ . '/../../common/config/params-local.php',
    //require __DIR__ . '/params.php',
    //require __DIR__ . '/params-local.php'
);
*/

$server = "localhost";
$username = "eulims";
$password = "eulims";//



return [
    
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'], 
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@console' =>  dirname(dirname(__DIR__)) . '/console',
        '@web/assets' => dirname(dirname(__DIR__)) . '/frontend/web/assets',
        '@webroot/assets' => dirname(dirname(__DIR__)) . '/frontend/web',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'templateFile' => '@jamband/schemadump/template.php',
        ],
        'schemadump' => [
            'class' => jamband\schemadump\SchemaDumpController::class,
            'db' => [
                'class' => yii\db\Connection::class,
                'dsn' => 'mysql:host=localhost;dbname=eulims',
                'username' => $username,
                'password' => $password,
            ],
        ],
    ],
    'components' => [
        'db'=>[
            'class' => 'yii\db\Connection',  
            'dsn' => 'mysql:host='.$server.';dbname=eulims',
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ],
      
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            //'class' => 'common\models\User',
            //'enableAutoLogin' => true,
            //'loginUrl' => ['admin/user/login'],
        ],
         'inventorydb'=>[
            'class' => 'yii\db\Connection',  
            'dsn' => 'mysql:host='.$server.';dbname=eulims_inventory',
            'username' => $username,
            'password' => $password,
            //'username'=>'arisro9',
            //'password'=>'qwerty!@#$%', 
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ],
        'labdb'=>[
            'class' => 'yii\db\Connection',  
            'dsn' => 'mysql:host='.$server.';dbname=eulims_lab',
            'username' => $username,
            'password' => $password,
            //'username'=>'arisro9',
            //'password'=>'qwerty!@#$%', 
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ],
        'financedb'=>[
            'class' => 'yii\db\Connection',  
            'dsn' => 'mysql:host='.$server.';dbname=eulims_finance',
            'username' => $username,
            'password' => $password,
            //'username'=>'arisro9',
            //'password'=>'qwerty!@#$%', 
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ],

        'user' => [
            //'identityClass' => 'mdm\admin\models\User',
            //'class'=>'mdm\admin\models\User',
            //'loginUrl' => ['admin/user/login'],
         //   'identityClass' => 'common\models\system\User',
            'class'=>'common\models\system\User',
        ],
        'session' => [ 
            'class' => 'yii\web\Session'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
             'useFileTransport' => false,//set this property to false to send mails to real email addresses
             //comment the following array to send mail using php's mail function
             'transport' => [
                 'class' => 'Swift_SmtpTransport',
                 'host' => 'smtp.gmail.com',
                 'username' => 'onelabmaps',
                 'password' => 'dneiqjzzfgbjlyff',
                 'port' => '587',
                 'encryption' => 'tls',
                 'streamOptions'=>[
                    'ssl'=>[
                         'verify_peer'=>false,
                         'verify_peer_name'=>false,
                         'allow_self_signed'=>true
                   ]
                 ]
             ],
     ],
       
        // 'request' => [

        //     'cookies' => [

        //         'class' => 'yii\web\Cookie',
    
        //         'httpOnly' => true,
    
        //         'secure' => true
    
        //     ],

        // ],
        

    ],
    //'params' => $params,
];
