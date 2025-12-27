<?php
/* @var $this \yii\web\View */

use app\models\WordCategory;
use app\models\WordImportForm;
use app\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model WordImportForm */
$this->title = Yii::t('app', 'Import words');
$this->params['back_link'] = Url::to(['category/index']);
?>

<div style="background: var(--bg-primary); padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: var(--spacing-lg) 0; border: 1px solid var(--border-color);">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'import-form'
    ]); ?>
        <?= $form->field($model, 'category_id')->dropDownList(WordCategory::map()) ?>
        <?= $form->field($model, 'separator')->dropDownList(WordImportForm::getSeparatorOptions(), [
            'prompt' => Yii::t('app', 'Select separator'),
            'id' => 'separator-select',
            'options' => ['semicolon' => ['selected' => true]]
        ]) ?>
        <?= $form->field($model, 'row')->textarea([
            'rows' => 12,
            'id' => 'import-textarea',
            'placeholder' => Yii::t('app', 'word{separator}translate', ['separator' => ' ; ']),
            'style' => 'font-family: monospace; font-size: 0.875rem;'
        ])->hint(Yii::t('app', 'Enter words in format: word{separator}translate (one per line)', ['separator' => ' [separator] '])) ?>

    <?= Html::submitButton(Yii::t('app', 'Import'), ['class' => 'ui teal button', 'style' => 'width: 100%; margin-top: var(--spacing-md);']) ?>
<?php
$js = <<<JS
var separatorLabels = {
    'tab': ' (Tab) ',
    'slash': ' // ',
    'semicolon': ' ; '
};

$('#separator-select').on('change', function() {
    var separator = $(this).val();
    var label = separatorLabels[separator] || ' ; ';
    $('#import-textarea').attr('placeholder', 'word' + label + 'translate');
});

// Set default value on page load
if (!$('#separator-select').val()) {
    $('#separator-select').val('semicolon').trigger('change');
}
JS;
$this->registerJs($js);
?>
<?php ActiveForm::end(); ?>
