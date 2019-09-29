<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<h2 class="ui teal image header" style="margin-top: 40px;">
    <div class="content">
        <?= Html::encode($this->title) ?>
    </div>
</h2>
<?= yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['site/auth'],
    'popupMode' => false,
]) ?>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'ui large form'],
]); ?>
    <div class="ui stacked segment">

        <?= Html::errorSummary($model)?>
        <div class="field">
            <div class="ui left icon input">
                <i class="user icon"></i>
                <?= Html::activeTextInput($model, 'email', ['placeholder' => Yii::t('app', 'E-mail address')])?>
                <?= Html::error($model, 'email')?>
            </div>
        </div>
        <div class="field">
            <div class="ui left icon input">
                <i class="lock icon"></i>
                <?= Html::activePasswordInput($model, 'password', ['placeholder' => Yii::t('app', 'Password')])?>
                <?= Html::error($model, 'password')?>
            </div>
        </div>
        <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'ui fluid large teal submit button', 'name' => 'login-button']) ?>
    </div>
    <div class="ui error message"></div>

<?php ActiveForm::end(); ?>

<div class="ui message">
    <?=Yii::t('app', 'New to us?');?>  <a href="<?=yii\helpers\Url::to(['site/signup'])?>"><?=Yii::t('app', 'Sign Up');?></a>
</div>