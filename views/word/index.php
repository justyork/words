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

<h1><?= Html::encode($this->title)?></h1>

<a href="<?=yii\helpers\Url::to(['word/create', 'id' => $model->id])?>" class="ui teal button"><?=Yii::t('app', 'Create new');?> </a>
<table class="ui separator table">
    <thead>
    <tr>
        <th><?=Yii::t('app', 'Word');?> </th>
        <th><?=Yii::t('app', 'Translate');?> </th>
        <th><?=Yii::t('app', 'Level');?> A / B</th>
        <th><?=Yii::t('app', 'Skip');?> </th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?if($model->words):?>
        <?foreach($model->words as $item):?>
            <tr>
                <td><?= $item->word?></td>
                <td><?= $item->translate?></td>
                <td class="collapsed"><?= (int)$item->level_ab . ' / ' . (int)$item->level_ba?></td>
                <td class="collapsed">
                    <a href="#" data-id="<?= $item->id?>" class="ui <?= $item->skip ? '' : 'teal'?> button icon skip-toggle">
                        <i class="eye <?= $item->skip ? 'slash' : ''?> icon"></i>
                    </a>
                </td>
                <td class="collapsed">
                    <a href="<?=yii\helpers\Url::to(['update', 'id' => $item->id])?>" class="ui button icon">
                        <i class="pencil icon "></i>
                    </a>
                    <a href="<?=yii\helpers\Url::to(['delete', 'id' => $item->id])?>" class="ui button icon" onclick="return confirm('<?=Yii::t('app', 'Are you sure?')?>')">
                        <i class="trash icon "></i>
                    </a>
                </td>
            </tr>
        <?endforeach?>
    <? else:?>
        <tr><td colspan="5"><?=Yii::t('app', 'Empty');?> </td></tr>
    <?endif?>
    </tbody>
</table>