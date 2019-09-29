<?php

use app\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\user\models\forms\LoginForm $model
 */

$this->title = Yii::t('user', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>


<h2 class="ui teal image header" style="margin-top: 40px;">
    <div class="content">
        <?= Html::encode($this->title) ?>
    </div>
</h2>

<?php if (Yii::$app->get("authClientCollection", false)): ?>
<!--    <div class="col-lg-offset-2 col-lg-10">-->
<!--        --><?//= yii\authclient\widgets\AuthChoice::widget([
//            'baseAuthUrl' => ['/user/auth/login']
//        ]) ?>
<!--    </div>-->
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'ui large form'],

]); ?>
<?= Html::errorSummary($model, ['class' => 'ui message yellow errors'])?>
<div class="ui stacked segment">
        <div class="field">
            <div class="ui left icon input">
                <i class="envelope icon"></i>
                <?= Html::activeTextInput($model, 'username', ['placeholder' => Yii::t('app', 'E-mail address')])?>
            </div>
        </div>
        <div class="field">
            <div class="ui left icon input">
                <i class="lock icon"></i>
                <?= Html::activePasswordInput($model, 'password', ['placeholder' => Yii::t('app', 'Password')])?>
            </div>
        </div>
    <?= $form->field($model, 'rememberMe', ['options' => ['style' => 'text-align: left;', 'class' => 'field']])->checkbox() ?>

        <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'ui fluid large teal submit button', 'name' => 'login-button']) ?>
    </div>
    <div class="ui message">
        <?= Html::a(Yii::t("user", "Register"), ["/user/register"]) ?> /
        <?= Html::a(Yii::t("user", "Forgot password") . "?", ["/user/forgot"]) ?> /
        <?= Html::a(Yii::t("user", "Resend confirmation email"), ["/user/resend"]) ?>
    </div>

<?php ActiveForm::end(); ?>


