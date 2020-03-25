<?php

//use app\components\Config;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
            'basePath' => '@app/modules/api',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
            'controllerMap' => [
                'default' => 'app\controllers\UserController1',
                'admin' => 'app\controllers\user\AdminController',
            ],
            'emailConfirmation' => false,
            'requireUsername' => false,
            'modelClasses'  => [
                'User' => 'app\models\User',
                'Role' => 'app\models\Role',
                'UserSearch' => 'app\models\search\UserSearch',
                'Profile' => 'app\models\Profile',
                'ForgotForm' => 'app\models\forms\ForgotForm',
                'LoginEmailForm' => 'app\models\forms\LoginEmailForm',
            ],
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '2Rqhs8WrQzWD_wS_lKCZiQTLd7n_40Xl',
            'baseUrl'=> '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],

        'settings' => [
            'class' => 'app\components\Settings'
        ],
//        'config' => [ 'class' => Config::className()],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\components\User',
            'enableAutoLogin' => true,
            'identityClass' => 'app\models\User',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => 'facebook_client_id',
                    'clientSecret' => 'facebook_client_secret',
                ],
                // etc.
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                ['class' => 'yii\rest\UrlRule', 'controller' => ['api/category']],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['api/stat']],
//                ['class' => 'yii\rest\UrlRule', 'controller' => ['api/pack']],
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/word'],
                'api/pack/<id:\d+>/<type:[a|b|r]+>/<new:[0|1]+>' => 'api/pack/get',
                'api/pack/<id:\d+>/<type:\w+>' => 'api/pack/get',
                'api/pack/<id:\d+>' => 'api/pack/get',
                'api/repeat' => 'api/learn/repeat',
                'api/<controller>/<action>' => 'api/<controller>/<action>',
                '<controller>/<action>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
