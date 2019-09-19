<?php
/* @var $this \yii\web\View */

use app\models\WordPack;

/* @var $model WordPack[] */
$this->title = Yii::t('app', 'Learn');
$this->params['breadcrumbs'] = [
    ['label' => $this->title],
];

?>


<div class="learn">

    <?if($model):?>
        <?foreach($model as $item):?>
            <div>
                <a href="<?=yii\helpers\Url::to(['learn/check', 'id' => $item->id])?>" class="btn btn-primary">
                    <?=Yii::t('app', 'Pack #{id} ({count} words) {date}', ['id' => $item->id, 'count' => $item->count, 'date' => Yii::$app->formatter->asRelativeTime($item->date)]);?>
                </a>
                <a href="<?=yii\helpers\Url::to(['learn/start', 'type' => 'ab', 'id' => $item->id])?>" class="btn btn-success">AB</a>
                <a href="<?=yii\helpers\Url::to(['learn/start', 'type' => 'ba', 'id' => $item->id])?>" class="btn btn-success">BA</a>
                <a href="<?=yii\helpers\Url::to(['learn/start', 'type' => 'r', 'id' => $item->id])?>" class="btn btn-success">R</a>

            </div>
        <?endforeach?>
    <?endif?>
</div>
