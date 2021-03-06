<?php
/* @var $this yii\web\View */
$js = <<<JS
$('#left-sb-btn').click(function() {
    $('#left-sidebar')
      .sidebar('toggle')
    ;
});
JS;
$this->registerJs($js);


use yii\widgets\Menu; ?>
<div class="ui left vertical invrert menu sidebar" id="left-sidebar">

    <?= Menu::widget(
        [
            "items" => [
                ["label" => Yii::t('app', 'Home'), "url" => "/", "icon" => "home"],
                ["label" => Yii::t('app', 'Categories'), "url" => ["category/index"]],
                ["label" => Yii::t('app', 'Logout'), "url" => ["site/logout"]],
            ],
            'options' => ['style' => 'padding: 0', 'tag' => 'div'],
            'itemOptions' => ['class' => 'item', 'tag' => false],
            'linkTemplate' => '<a href="{url}" class="item">{label}</a>'
        ]
    )
    ?>
</div>