<?php

/* @var $this yii\web\View */
/* @var $packs WordPack[] */

$this->title = 'Words';

use app\models\WordPack; ?>
<div class="site-index">

<!--    <div>CHARTS</div>-->

<!--    -->
<!--    <button class="ui basic button ">-->
<!--        <i class="icon exclamation"></i>-->
<!--        --><?//=Yii::t('app', 'Repeat words');?>
<!--    </button>-->
    <a href="<?=yii\helpers\Url::to(['category/create'])?>" class="ui blue button"><?=Yii::t('app', 'Create category');?></a>
    <h4 class="ui horizontal divider">
        <?=Yii::t('app', 'Latest packs');?>
    </h4>

    <?if($packs):?>
        <div class="ui small aligned divided list" style="max-width: 400px;">
            <?foreach($packs as $item):?>
                <pack-row
                        @selectrow="selectrow"
                        pack_id="<?= $item->id?>"
                        check_link="<?=yii\helpers\Url::to(['learn/check', 'id' => $item->id])?>"
                        learn_link="<?=yii\helpers\Url::to(['learn/start', 'id' => $item->id, 'type' => ''])?>"
                        label="<?=Yii::t('app', 'Pack #{id} ({count})', ['id' => $item->id, 'count' => $item->count]);?>"
                        :can_select="false"
                ></pack-row>
            <?endforeach?>
        </div>
    <?else:?>
        <h5><?=Yii::t('app', 'No packs yet');?></h5>
    <?endif?>

</div>
