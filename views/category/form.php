<?php
/**
 * Author: yorks
 * Date: 18.09.2019
 */

use app\models\WordCategory;
use app\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $model WordCategory */

$this->title = $model->isNewRecord ? Yii::t('app', 'Create category') : \Yii::t('app', 'Update category: {name}', ['name' => $model->title]);

$this->params['back_link'] = Url::to(['category/index']);
?>
<h1><?= Html::encode($this->title)?></h1>
<?php $form = ActiveForm::begin([
    'id' => 'create-category-form'
]); ?>
    <?=$form->field($model, 'title')?>
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'ui teal button'])?>
<?php ActiveForm::end(); ?>
