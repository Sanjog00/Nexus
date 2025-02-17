<?php

use app\models\Usersmain;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'login-signup/base',
    'defaultRoute' => 'site/login',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
        ],
    ],
    'components' => [
        'session' => [
            'class' => 'yii\web\Session',
            'timeout' => 9000, // 15 minutes
            'on beforeClose' => function ($session) {
                $userMain = Usersmain::findOne(['user_id' => Yii::$app->user->id]);
                if ($userMain) {
                    $userMain->active_status = false;
                    $userMain->save();
                }
            },
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'yARdpVqWlmlVTkO5nx9qxKM7V6BcVcSE',

        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'amnah\yii2\user\components\User',
            'authTimeout' => 9000,
            'enableAutoLogin' => true,

        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'scheme' => 'smtp',
                'host' => 'smtp.gmail.com',
                'username' => 'kenjikun3289@gmail.com',
                'password' => 'uecm kiah azcj ncoz',
                'port' => 587,
                'encryption' => 'tls',
            ],

            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['kenjikun3289@gmail.com' => 'Nexus Admin']
            ],

        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'app/profile-view/<username>' => 'app/profile-view/',
                'app/settings-modal' => 'app/settings-modal',
                'app/search-messages' => 'app/search-messages',
                'photos' => 'site/photos',
                'get-photos' => 'site/get-photos',
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {


    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
