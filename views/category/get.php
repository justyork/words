<?php

use app\models\PackForm;
use app\models\WordCategory;
use app\widgets\ActiveForm;
use app\widgets\Checkbox;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $model WordCategory */
/* @var $packForm PackForm */
$this->params['back_link'] = Url::to(['category/index']);
?>

<h1><?= $model->title?></h1>

<a href="<?=yii\helpers\Url::to(['word/index', 'id' => $model->id])?>" class="ui blue button"><?=Yii::t('app', 'Show words');?></a>

<a href="#" data-modal="add-pack" class="ui blue basic button"><?=Yii::t('app', 'Add pack');?></a>


<h4 class="ui horizontal divider">
    <?=Yii::t('app', 'Packs');?>
</h4>

<?= Html::errorSummary($packForm)?>

<?if($model->packs):?>
<div class="ui small aligned divided list" style="max-width: 400px;">
    <?foreach($model->getPacks()->orderBy('date DESC')->all() as $item):?>

        <div class="item">
            <pack-row
                    @selectrow="selectrow"
                    pack_id="<?= $item->id?>"
                    check_link="<?=yii\helpers\Url::to(['learn/check', 'id' => $item->id])?>"
                    learn_link="<?=yii\helpers\Url::to(['learn/start', 'id' => $item->id, 'type' => ''])?>"
                    label="<?=Yii::t('app', 'Pack #{id} ({count})', ['id' => $item->id, 'count' => $item->count]);?>"
            ></pack-row>
        </div>
    <?endforeach?>
    <div class="ui fluid buttons" v-if="selectedRow.length">
        <a :href="'<?=yii\helpers\Url::to(['merge', 'items' => ''])?>'+selectedRow.join(',')" class="ui green button"><?=Yii::t('app', 'Merge');?> </a>
        <a :href="'<?=yii\helpers\Url::to(['delete-packs', 'items' => ''])?>'+selectedRow.join(',')"  class="ui red button"><?=Yii::t('app', 'Delete');?> </a>
    </div>
</div>
<?else:?>
    <h5><?=Yii::t('app', 'No packs yet');?></h5>
    <a href="#" data-modal="add-pack" class="ui green basic button"><?=Yii::t('app', 'Add pack');?></a>
<?endif?>

<div class="ui mini modal" id="add-pack">
    <i class="close icon"></i>
    <div class="image content">
        <?php $form = ActiveForm::begin([
            'id' => 'add-pack-form',
            'options' => ['class' => 'ui form']
        ]); ?>
            <div class="ui horizontal list " style="padding-bottom: 20px">
                <div class="item"><?=$form->field($packForm, 'count')?></div>
                <div class="item" style="top: 10px;position: relative;"><?=$form->field($packForm, 'onlyNew')->widget(Checkbox::className())->label(false)?></div>
            </div>
            <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'fluid ui green button'])?>
        <?php ActiveForm::end(); ?>
    </div>

</div>