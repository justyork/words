<?php
/**
 * Author: yorks
 * Date: 26.10.2019
 */

namespace app\modules\api\controllers;


use app\models\Word;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\rest\Controller;

class LearnController extends Controller
{

    public function behaviors()
    {
        $data = parent::behaviors();
        $data['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['count-repeat-words', 'repeat-words', 'repeat'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $data;
    }

    public function actionRepeatWords(){
        $words = Word::repeatWords();
        shuffle($words);
        return $words;
    }

    public function actionCountRepeatWords(){
        return count(Word::repeatWords());
    }
}