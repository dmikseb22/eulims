<?php
use kartik\mpdf\Pdf;
/**
 * This class perform backup of databases incrementally
 * Databases list on configurations
 */
return [
    'mailer' => [
           'class' => 'yii\swiftmailer\Mailer',
           'viewPath' => '@common/mail',
            'useFileTransport' => false,//set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'dost9ict@gmail.com',
                'password' => 'efsepgobqhceacai',
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
    'backup' => [
        'class' => 'common\modules\dbmanager\components\BackupUtility',
        // The directory for storing backups files
        'backupsFolder' =>dirname(dirname(__DIR__)) . '/frontend/web/backups',
        // Name template for backup files.
        // if string - return date('Y_m_d-H_i_s')
        'backupFilename' => 'Y_m_d-H_i_s',
        // also can be callable:
        //'backupFilename' => function (common\components\BackupUtility $component) {
        //    return date('Y_m_d-H_i_s');
        //},

        // Directories that will be added to backup
        'directories' => [
            // format: <inner backup filename> => <path/to/dir>
            'images' => '@frontend/web/images',
            'uploads' => '@common/modules/profile/assets/photo',
        ],

        // Name of Database component. By default Yii::$app->db.
        // If you don't want backup project database
        // you can set this param as NULL/FALSE.
        'db' =>'db',
        'ext'=>'zip',// set the extension of the compressed file
        // List of databases connections config.
        // If you set $db param, then $databases automatically
        // will be extended with params from Yii::$app->$db.
        'databases' => [
            'eulims'=>[
                'db'=>'eulims',
                'username'=>'eulims',
                'password'=>'eulims',
                'host'=>'localhost',
            ],
            'eulims_lab'=>[
                'db'=>'eulims_lab',
                'username'=>'eulims',
                'password'=>'eulims',
                'host'=>'localhost',
            ],
            'eulims_inventory'=>[
                'db'=>'eulims_inventory',
                'username'=>'eulims',
                'password'=>'eulims',
                'host'=>'localhost',
            ],
            'eulims_finance'=>[
                'db'=>'eulims_finance',
                'username'=>'eulims',
                'password'=>'eulims',
                'host'=>'localhost',
            ],
            'eulims_address'=>[
                'db'=>'eulims_address',
                'username'=>'eulims',
                'password'=>'eulims',
                'host'=>'localhost',
            ],
            'eulims_referral_lab'=>[
                'db'=>'eulims_referral_lab',
                'username'=>'eulims',
                'password'=>'eulims',
                'host'=>'localhost',
            ],
            // It will generate "/sql/logs_table.sql.gz" with 
            // dump file "logs_table.sql" of database 'logs'.
            // You can set custom 'mysqldump' command for each database,
        ],
        // CLI command for creating each database backup.
        // If $databases password is empty,
        // then will be executed: str_replace('-p\'{password}\'', '', $command);
        // it helpful when mysql password is not set.
        // You can override this command with you custom params,
        // just add them to $databases config.
        //'mysqldump' => "\"C:\Program Files\MySQL\MySQL Server 5.7\bin\mysqldump\" --add-drop-table --allow-keywords -q -c -u{username} -h{host} -p{password} {db} | gzip -9",
        'mysqldump'=>"--add-drop-table --allow-keywords -q -c -u{username} -h{host} -p{password} --databases {db}",
        // Number of seconds after which the file is considered deprecated and will be deleted.
        // To prevent deleting any files you can set this param as NULL/FALSE/0.
        'expireTime' => 2592000, // 1 month
    ],
    'cache' => [
            'class' => 'yii\caching\FileCache',
    ],
    'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
            'defaultRoles' => ['Guest'],
    ],
    'user' => [
            //'identityClass' => 'mdm\admin\models\User',
            //'class'=>'mdm\admin\models\User',
            //'loginUrl' => ['admin/user/login'],
            'identityClass' => 'common\models\User',
            //'class'=>'common\models\User',
    ],
    'pdf' => [
        'class' => Pdf::classname(),
        'format' => Pdf::FORMAT_A4,
        'orientation' => Pdf::ORIENT_PORTRAIT,
        'destination' => Pdf::DEST_BROWSER
        // refer settings section for all configuration options
    ],
    'jwt' => [
        'class' => 'sizeg\jwt\Jwt',
        'key' => 'secret',
    ],
];
 
