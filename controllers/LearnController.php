<?php


namespace app\controllers;


use app\models\WordCategory;
use app\models\WordPack;
use yii\web\Controller;

class LearnController extends Controller
{
//    public $layout = 'learn';

    public function actionIndex(){
        $model = WordPack::find()->all();

        return $this->render('index', compact('model'));
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