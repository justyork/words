<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);


?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class=" body">
<?php $this->beginBody(); ?>
    <?= $this->render('//common/header') ?>
    <?= $this->render('//common/sidebar') ?>
    <?= $this->render('//common/sidebar_right') ?>
    <div class="ui container vue-block">
        <?php /* $this->render('/common/sidebar') */ ?>
        <!-- page content -->
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs']
        ]) ?>
        <?= $content ?>

    </div>
</div>
<?= $this->render('//common/js_links') ?>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
