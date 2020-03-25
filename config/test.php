<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
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
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'class' => 'app\components\User',
            'enableAutoLogin' => true,
            'identityClass' => 'app\models\User',
        ],
        'settings' => [
            'class' => 'app\components\Settings'
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
