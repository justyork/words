<?php
/**
 * Author: yorks
 * Date: 18.09.2019
 */
/* @var $this \yii\web\View */
/* @var $model \app\models\WordCategory|null */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
$this->params['back_link'] = Url::to(['category/get', 'id' => $model->id]);
?>

<div style="background: var(--bg-primary); padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: var(--spacing-lg) 0; border: 1px solid var(--border-color);">
    <h1><?= Html::encode($this->title) ?></h1>

    <div style="margin-bottom: var(--spacing-lg);">
        <a href="<?= yii\helpers\Url::to(['word/create', 'id' => $model->id]) ?>" class="ui teal button" style="width: 100%;"><?= Yii::t('app', 'Create new'); ?> </a>
    </div>
    
    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="ui separator table">
            <thead>
            <tr>
                <th><?=Yii::t('app', 'Word');?> </th>
                <th><?=Yii::t('app', 'Translate');?> </th>
                <th><?=Yii::t('app', 'Level');?> A / B</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($model->words): ?>
                <?php foreach ($model->words as $item): ?>
                    <tr>
                        <td data-label="<?=Yii::t('app', 'Word');?>" style="font-weight: 500;"><?= $item->word ?></td>
                        <td data-label="<?=Yii::t('app', 'Translate');?>"><?= $item->translate ?></td>
                        <td class="collapsed" data-label="<?=Yii::t('app', 'Level');?>"><?= (int)$item->a_level . ' / ' . (int)$item->b_level ?></td>
                        <td class="collapsed" style="vertical-align: middle; text-align: right;">
                            <div style="display: inline-flex; gap: 0.375rem; align-items: center; justify-content: flex-end;">
                                <a href="#" data-id="<?= $item->id ?>" class="ui <?= $item->skip ? '' : 'teal' ?> button icon skip-toggle">
                                    <i class="eye <?= $item->skip ? 'slash' : '' ?> icon"></i>
                                </a>
                                <a href="<?= yii\helpers\Url::to(['update', 'id' => $item->id]) ?>" class="ui button icon">
                                    <i class="pencil icon"></i>
                                </a>
                                <a href="<?= yii\helpers\Url::to(['delete', 'id' => $item->id]) ?>" class="ui button icon" onclick="return confirm('<?= Yii::t('app', 'Are you sure?') ?>')">
                                    <i class="trash icon"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align: center; padding: var(--spacing-xl); color: var(--text-secondary);"><?= Yii::t('app', 'Empty'); ?> </td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
@media (min-width: 640px) {
    div[style*="width: 100%"] .ui.button {
        width: auto !important;
    }
}
</style>
