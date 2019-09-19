<?php
/* @var $this \yii\web\View */
/* @var $model WordCategory[] */
$this->title = Yii::t('app', 'Categories');
use app\models\WordCategory;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['back_link'] = Url::to(['site/index']);
?>
<div class="categories">
    <h1><?= Html::encode($this->title)?></h1>

    <a class="ui teal button " href="<?=yii\helpers\Url::to(['create'])?>"><?=Yii::t('app', 'Create new');?> </a>
    <a class="ui blue button " href="<?=yii\helpers\Url::to(['import'])?>"><?=Yii::t('app', 'Import words');?> </a>


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
        <?if($model):?>
            <?foreach($model as $item):?>
                <tr>
                    <td>
                        <a href="<?=yii\helpers\Url::to(['get', 'id' => $item->id])?>">
                            <?= $item->title?>
                        </a>
                    </td>
                    <td class="collapsing"><?= Yii::$app->formatter->asRelativeTime($item->last_update)?></td>
                    <td class="collapsing"><?= count($item->words)?></td>
                    <td class="right aligned collapsing">
                        <a href="<?=yii\helpers\Url::to(['update', 'id' => $item->id])?>" class="ui button icon">
                            <i class="pencil icon "></i>
                        </a>
                        <a href="<?=yii\helpers\Url::to(['delete', 'id' => $item->id])?>" class="ui button icon" onclick="return confirm('<?=Yii::t('app', 'Are you sure?')?>')">
                            <i class="trash icon "></i>
                        </a>
                    </td>
                </tr>
            <?endforeach?>
        <?else:?>
            <tr>
                <td><?=Yii::t('app', 'Empty');?> </td>
            </tr>
        <?endif?>
        </tbody>
    </table>
</div>