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
<?if($this->params['sidebar']):?>
    <div class="ui right vertical invrert menu sidebar" id="right-sidebar">
        <?= Menu::widget(
            [
                "items" => $this->params['sidebar'],
                'options' => ['style' => 'padding: 0'],
                'itemOptions' => ['class' => 'item']
            ]
        )
        ?>
    </div>
<?endif?>
