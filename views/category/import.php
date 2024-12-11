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

<h1><?= Html::encode($this->title)?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'import-form'
]); ?>
    <?=$form->field($model, 'category_id')->dropDownList(WordCategory::map())?>
    <?=$form->field($model, 'row')->textarea(['rows' => 10])->hint(Yii::t('app', 'word'.$_ENV['IMPORT_SEPARATOR'].' translate'))?>

<?= Html::submitButton(Yii::t('app', 'Import'), ['class' => 'ui teal button'])?>
<?php ActiveForm::end(); ?>
