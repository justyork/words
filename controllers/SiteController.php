<?php

namespace app\controllers;

use app\components\AuthHandler;
use app\models\Word;
use app\models\WordPack;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
//                    [
//                        'actions' => ['login', 'signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [

//            'auth' => [
//                'class' => 'yii\authclient\AuthAction',
//                'successCallback' => [$this, 'onAuthSuccess'],
//            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $packs = WordPack::find()->where(['user_id' => Yii::$app->user->id])->orderBy('date DESC')->limit(10)->all();
        $countWords = count(Word::repeatWords());
        return $this->render('index', compact('packs', 'countWords'));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'auth';

        $model = new LoginForm();

        // load post data and login
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $returnUrl = $this->performLogin($model->getUser(), $model->rememberMe);
            return $this->redirect($returnUrl);
        }

        return $this->render('login', compact("model"));
    }

    protected function performLogin($user, $rememberMe = true)
    {
        // log user in
        $loginDuration = 3600*24*30;
        Yii::$app->user->login($user, $loginDuration);

        // check for a valid returnUrl (to prevent a weird login bug)
        //   https://github.com/amnah/yii2-user/issues/115
        $loginRedirect = $this->goHome();
        $returnUrl = Yii::$app->user->getReturnUrl($loginRedirect);
        if (strpos($returnUrl, "site/login") !== false || strpos($returnUrl, "site/logout") !== false) {
            $returnUrl = null;
        }

        return $returnUrl;
    }

    public function actionSignup()
    {
        $this->layout = 'auth';

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
