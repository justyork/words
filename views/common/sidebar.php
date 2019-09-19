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
                ["label" => "Home", "url" => "/", "icon" => "home"],
                ["label" => "Categories", "url" => ["category/index"]],
            ],
            'options' => ['style' => 'padding: 0'],
            'itemOptions' => ['class' => 'item']
        ]
    )
    ?>
</div>