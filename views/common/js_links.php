<?php
/**
 * Author: yorks
 * Date: 18.09.2019
 */

use yii\helpers\Url;
use yii\web\View;

/* @var $this \yii\web\View */

$skipWord = Url::to(['word/skip']);


$js = <<<JS
    var _links = {
        skip_word: '{$skipWord}'
    };
JS;
$this->registerJs($js, View::POS_BEGIN);

