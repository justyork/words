<?php
/* @var $item WordPack */
/* @var $this yii\web\View */
use app\models\WordPack;

?>

<div class="item">
    <div class="ui  buttons">
        <a href="<?= yii\helpers\Url::to(['learn/check', 'id' => $item->id]) ?>" class="ui blue button" style="width: 150px">
            <?= Yii::t('app', 'Pack #{id} ({count})', ['id' => $item->id, 'count' => $item->count]); ?>
        </a>
        <a href="<?= yii\helpers\Url::to(['learn/start', 'id' => $item->id, 'type' => 'ab']) ?>" class="ui  blue basic button icon">
            <i class="arrow down icon"></i>
        </a>
        <a href="<?= yii\helpers\Url::to(['learn/start', 'id' => $item->id, 'type' => 'ba']) ?>" class="ui  blue basic button icon">
            <i class="arrow up icon"></i>
        </a>
        <a href="<?= yii\helpers\Url::to(['learn/start', 'id' => $item->id, 'type' => 'r']) ?>" class="ui  teal button icon">
            <i class="shuffle icon"></i>
        </a>
    </div>
    <button class="ui toggle button pack-row" @click="selectrow(<?= $item->id ?>)">
        Select
    </button>
</div>
