<?php

$params = require __DIR__ . '/params.php';

/**
 * return [
 *   'class' => 'yii\db\Connection',
 *   'dsn' => 'mysql:host=localhost;dbname=dbname',
 *   'username' => 'username',
 *   'password' => 'password',
 *   'charset' => 'utf8',
 *   // Schema cache options (for production environment)
 *   'enableSchemaCache' => true,
 *   'schemaCacheDuration' => 10,
 *   'schemaCache' => 'cache',
 * ];
 * */
$db = require __DIR__ . '/db.php';

/**
 * return [
 *     'class'         => 'yii\swiftmailer\Mailer',
 *     'transport'     => [
 *         'class'      => 'Swift_SmtpTransport',
 *         'host'       => 'smtp.gmail.com',
 *         'username'   => 'my@mail.com',
 *         'password'   => 'myMailPassword',
 *         'port'       => '587', // Port 25 is a very common port too
 *         'encryption' => 'tls', // It is often used, check your provider or mail server specs
 *     ],
 *     'messageConfig' => [
 *         'from'    => ['my@mail.com' => 'zloradnij admin'], // this is needed for sending emails
 *         'charset' => 'UTF-8',
 *     ],
 * ];
 */
$mail = require __DIR__ . '/mailer.php';

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language'   => 'ru-RU',
    'modules'    => [
        'user'    => [
            'class' => 'dektrium\user\Module',
            // ...other configs from here: [Configuration Options](installation/configuration-options.md), e.g.
            // 'generatePasswords' => true,
            // 'switchIdentitySessionKey' => 'myown_usuario_admin_user_key',

            'controllerMap' => [
                'admin' => [
                    'class'     => 'dektrium\user\controllers\AdminController',
                    'as access' => [
                        'class' => 'yii\filters\AccessControl',
                        'rules' => [
                            [
                                'allow' => TRUE,
                                'roles' => ['admin'],
                            ],
                            [
                                'actions' => ['switch'],
                                'allow'   => TRUE,
                                'roles'   => ['@'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'control' => [
            'class' => 'app\modules\control\Module',
        ],
        'shop'    => [
            'class' => 'app\modules\shop\Module',
        ],
    ],
    'components' => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Sv75o6kiKZSrOSdHQPueEtOJYhKKpT7e',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
//            'identityClass'   => 'app\models\User',
//            'enableAutoLogin' => TRUE,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer'       => $mail,
        'db'           => $db,
        'authManager'  => [
            'class' => 'yii\rbac\DbManager',
        ],

        'urlManager' => [
            'enablePrettyUrl' => TRUE,
            'showScriptName'  => FALSE,
            'rules'           => [
            ],
        ],
        'i18n'       => [
            'translations' => [
                /**
                 * shop название нашего php файла переводов который нужно создать shop.php (может быть любым)
                 * */
                'shop*' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    /**
                     * путь для нашего файла переводов app/messages/ru/shop.php
                     * */
                    'basePath'       => '@app/messages',
                    /**
                     * язык с какого переводим, то есть, в проекте все надписи пишем на английском
                     * */
                    'sourceLanguage' => 'en-US',
                ],
            ],
        ],
    ],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.10.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.10.1'],
    ];
}

return $config;
