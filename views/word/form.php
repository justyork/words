<?php
/**
 * Author: yorks
 * Date: 18.09.2019
 */
/* @var $this \yii\web\View */
/* @var $model \app\models\Word|null */
use app\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->isNewRecord ? \Yii::t('app', 'Create new word') : Yii::t('app', 'Update word: {word}', ['word' => $model->word]);

$this->params['back_link'] = Url::to(['word/index', 'id' => $model->category_id]);
?>

<h1><?= Html::encode($this->title)?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'word-form'
]); ?>
    <?=$form->field($model, 'word')?>
    <?=$form->field($model, 'translate')?>

    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'ui teal button'])?>
<?php ActiveForm::end(); ?>
