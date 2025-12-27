<?php
/* @var $this yii\web\View */
$js = <<<JS
$('#right-sb-btn').click(function() {
    $('#right-sidebar')
      .sidebar('toggle')
    ;
});
JS;
$this->registerJs($js);



use yii\widgets\Menu; ?>
<?php if (!empty($this->params['sidebar']) && is_array($this->params['sidebar'])): ?>
    <div class="ui right vertical invrert menu sidebar" id="right-sidebar">
        <?= Menu::widget(
            [
                "items" => $this->params['sidebar'],
                'options' => ['style' => 'padding: 0', 'tag' => 'div'],
                'itemOptions' => ['class' => 'item', 'tag' => false],
                'linkTemplate' => '<a href="{url}" class="item">{label}</a>'
            ]
        )
        ?>
    </div>
<?php endif; ?>
