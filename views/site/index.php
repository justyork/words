<?php

/* @var $this yii\web\View */
/* @var $packs WordPack[] */

$this->title = 'My Yii Application';

use app\models\WordPack; ?>
<div class="site-index">

    <div>CHARTS</div>

    <button class="ui basic button ">
        <i class="icon exclamation"></i>
        <?=Yii::t('app', 'Repeat words');?>
    </button>
    <h4 class="ui horizontal divider">
        <?=Yii::t('app', 'Latest packs');?>
    </h4>

    <?if($packs):?>
        <div class="ui small aligned divided list" style="max-width: 400px;">
            <?foreach($packs as $item):?>
                <?= $this->render('//common/_pack_row', compact('item'))?>
            <?endforeach?>
        </div>
    <?else:?>
        <h5><?=Yii::t('app', 'No packs yet');?></h5>
    <?endif?>

</div>
