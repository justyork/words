<?php
/* @var $this \yii\web\View */
/* @var $model WordCategory[] */
$this->title = Yii::t('app', 'Category list');
use app\models\WordCategory;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['back_link'] = Url::to(['site/index']);
?>
<div class="categories">
    <h1><?= Html::encode($this->title) ?></h1>

    <div style="margin-bottom: var(--spacing-lg); display: flex; flex-direction: column; gap: var(--spacing-sm);">
        <a class="ui teal button" href="<?= yii\helpers\Url::to(['create']) ?>" style="width: 100%;"><?= Yii::t('app', 'Create new'); ?> </a>
        <a class="ui blue button" href="<?= yii\helpers\Url::to(['import']) ?>" style="width: 100%;"><?= Yii::t('app', 'Import words'); ?> </a>
    </div>
    
    <style>
    @media (min-width: 640px) {
        .categories > div[style*="flex-direction"] {
            flex-direction: row !important;
        }
        
        .categories > div[style*="flex-direction"] .ui.button {
            width: auto !important;
            flex: 1;
        }
    }
    </style>


    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="ui celled striped table">
            <thead>
                <tr>
                    <th><?=Yii::t('app', 'Title');?> </th>
                    <th><?=Yii::t('app', 'Last update');?></th>
                    <th><?=Yii::t('app', 'Count words');?> </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php if ($model): ?>
                <?php foreach ($model as $item): ?>
                    <tr>
                        <td data-label="<?=Yii::t('app', 'Title');?>">
                            <a href="<?= yii\helpers\Url::to(['get', 'id' => $item->id]) ?>" style="font-weight: 500; color: var(--primary-color);">
                                <?= $item->title ?>
                            </a>
                        </td>
                        <td class="collapsing" data-label="<?=Yii::t('app', 'Last update');?>"><?= Yii::$app->formatter->asRelativeTime($item->last_update) ?></td>
                        <td class="collapsing" data-label="<?=Yii::t('app', 'Count words');?>"><?= count($item->words) ?></td>
                        <td class="right aligned collapsing">
                            <div style="display: flex; gap: var(--spacing-xs); justify-content: flex-end;">
                                <a href="<?= yii\helpers\Url::to(['update', 'id' => $item->id]) ?>" class="ui button icon" style="min-width: 44px; min-height: 44px;">
                                    <i class="pencil icon "></i>
                                </a>
                                <a href="<?= yii\helpers\Url::to(['delete', 'id' => $item->id]) ?>" class="ui button icon" style="min-width: 44px; min-height: 44px;" onclick="return confirm('<?= Yii::t('app', 'Are you sure?') ?>')">
                                    <i class="trash icon "></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: var(--spacing-xl); color: var(--text-secondary);"><?= Yii::t('app', 'Empty'); ?> </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
