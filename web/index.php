<?php
// comment out the following two lines when deployed to production

require __DIR__ . '/../vendor/autoload.php';

(new Dotenv\Dotenv(__DIR__ . '/../'))->load();

defined('YII_DEBUG') or define('YII_DEBUG', getenv('APP_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('APP_ENV'));

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
