<?php
/* @var $this \yii\web\View */

use app\models\WordPack;

/* @var $model WordPack[] */
$this->title = Yii::t('app', 'Learn');
$this->params['breadcrumbs'] = [
    ['label' => $this->title],
];

?>


<div class="learn" style="background: var(--bg-primary); padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: var(--spacing-lg) 0; border: 1px solid var(--border-color);">

    <?php if ($model): ?>
        <?php foreach ($model as $item): ?>
            <div style="background: var(--bg-secondary); padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-md); border: 1px solid var(--border-color);">
                <a href="<?= yii\helpers\Url::to(['learn/check', 'id' => $item->id]) ?>" class="btn btn-primary" style="display: block; margin-bottom: var(--spacing-sm); text-align: center; width: 100%; padding: var(--spacing-md);">
                    <?= Yii::t('app', 'Pack #{id} ({count} words) {date}', ['id' => $item->id, 'count' => $item->count, 'date' => Yii::$app->formatter->asRelativeTime($item->date)]); ?>
                </a>
                <div style="display: flex; flex-direction: column; gap: var(--spacing-xs);">
                    <a href="<?= yii\helpers\Url::to(['learn/start', 'type' => 'ab', 'id' => $item->id]) ?>" class="btn btn-success" style="width: 100%;">AB</a>
                    <a href="<?= yii\helpers\Url::to(['learn/start', 'type' => 'ba', 'id' => $item->id]) ?>" class="btn btn-success" style="width: 100%;">BA</a>
                    <a href="<?= yii\helpers\Url::to(['learn/start', 'type' => 'r', 'id' => $item->id]) ?>" class="btn btn-success" style="width: 100%;">R</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>
@media (min-width: 640px) {
    .learn > div[style*="flex-direction"] {
        flex-direction: row !important;
    }
    
    .learn > div[style*="flex-direction"] .btn {
        width: auto !important;
        flex: 1;
    }
}
</style>
