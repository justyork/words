<?php
/**
 * Author: yorks
 * Date: 05.10.2019
 */

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $count int */
/* @var $limit int */

$this->title = \Yii::t('app', 'Repeat');
$this->params['back_link'] = Url::to(['site/index']);

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$limit = isset($limit) ? (int)$limit : 0;
?>

<?php if ($count): ?>
    <div style="background: var(--bg-primary); padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: var(--spacing-lg) 0; border: 1px solid var(--border-color);">
        <?php if ($limit > 0): ?>
            <div style="margin-bottom: var(--spacing-md); padding: var(--spacing-sm); background: var(--bg-secondary); border-radius: var(--radius-md); color: var(--text-secondary); font-size: 0.875rem; text-align: center;">
                <?= Yii::t('app', 'Repeating {limit} words from {total} available', ['limit' => $limit, 'total' => $count]) ?>
            </div>
        <?php endif; ?>
        
        <learn repeat="1" only_new="1" type="r" category_id="<?= $category_id ?>" limit="<?= $limit ?>"></learn>
    </div>
<?php else: ?>
    <div style="background: var(--bg-primary); padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: var(--spacing-lg) 0; border: 1px solid var(--border-color); text-align: center;">
        <p style="color: var(--text-secondary); font-size: 1.125rem;"><?= Yii::t('app', 'Words not found'); ?></p>
    </div>
<?php endif; ?>
