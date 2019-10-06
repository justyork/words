<?php
/**
 * Author: yorks
 * Date: 05.10.2019
 */

use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $count int */

$this->title = \Yii::t('app', 'Repeat');
$this->params['back_link'] = Url::to(['site/index']);
?>

<?if($count):?>
    <learn repeat="1" type="r"></learn>
<?else:?>
    <?=Yii::t('app', 'Words not found');?>
<?endif?>
