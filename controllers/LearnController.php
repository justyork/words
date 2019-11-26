<?php


namespace app\controllers;


use app\models\Word;
use app\models\WordCategory;
use app\models\WordPack;
use yii\filters\AccessControl;
use yii\web\Controller;

class LearnController extends Controller
{
//    public $layout = 'learn';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['check', 'start', 'index', 'repeat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex(){
        $model = WordPack::find()->all();

        return $this->render('index', compact('model'));
    }

    public function actionRepeat($category_id = false){
        $count = count(Word::repeatWords($category_id));
        return $this->render('repeat', compact('count'));
    }
    public function actionStart($id){
        $model = WordPack::findOne($id);

        return $this->render('start', compact('model'));
    }
    public function actionCheck($id){
        $model = WordPack::findOne($id);

        return $this->render('check', compact('model'));
    }

}