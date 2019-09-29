<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\user\Module $module
 * @var app\modules\user\models\User $user
 * @var app\modules\user\models\User $profile
 * @var string $userDisplayName
 */

$module = $this->context->module;

$this->title = Yii::t('user', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-register">

    <h2 class="ui teal image header" style="margin-top: 40px;">
        <div class="content">
            <?= Html::encode($this->title) ?>
        </div>
    </h2>

<!--    --><?php //if (Yii::$app->get("authClientCollection", false)): ?>
<!--        <div class="col-lg-offset-2 col-lg-10">-->
<!--            --><?//= yii\authclient\widgets\AuthChoice::widget([
//                'baseAuthUrl' => ['/user/auth/login']
//            ]) ?>
<!--        </div>-->
<!--    --><?php //endif; ?>
    <?php if ($flash = Yii::$app->session->getFlash("Register-success")): ?>

        <div class="alert alert-success">
            <p><?= $flash ?></p>
        </div>

    <?php else: ?>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'options' => ['class' => 'ui large form'],
            'enableAjaxValidation' => true,
        ]); ?>
        <?= Html::errorSummary([$user, $profile], ['class' => 'ui message yellow errors'])?>
            <div class="ui stacked segment">

                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <?= Html::activeTextInput($profile, 'full_name', ['placeholder' => Yii::t('app', 'Name')])?>
                    </div>
                </div>


                <?php if ($module->requireEmail): ?>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="envelope icon"></i>
                            <?= Html::activeTextInput($user, 'email', ['placeholder' => Yii::t('app', 'Email')])?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <?= Html::activePasswordInput($user, 'newPassword', ['placeholder' => Yii::t('app', 'Password')])?>
                    </div>
                </div>
                <?= Html::submitButton(Yii::t('app', 'Register'), ['class' => 'ui fluid large teal submit button', 'name' => 'login-button']) ?>

            </div>
            <div class="ui message">
                <?= Html::a(Yii::t('user', 'Login'), ["/user/login"]) ?>
            </div>
        <?php ActiveForm::end(); ?>


    <?php endif; ?>

</div>