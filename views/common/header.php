<?php
/* @var $this yii\web\View */
$back = $this->params['back_link'];
?>
<div class="ui borderless main icon menu" style="">
    <div class="ui container">

        <?if($back):?>
            <a href="<?= $back?>" class="item">
                <i class="arrow left icon"></i>
            </a>
        <?endif?>
        <a href="#" class="item" id="left-sb-btn">
            <i class="bars icon"></i>
        </a>
        <div class="header center item">
            <a href="<?=yii\helpers\Url::to(['site/index'])?>">LWords</a>
        </div>

        <?if($this->params['sidebar']):?>
        <a href="#" class="item right floated" id="right-sb-btn">
            <i class="cog icon"></i>
        </a>
        <?endif;?>
    </div>
</div>