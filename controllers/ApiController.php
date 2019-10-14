<?php


namespace app\controllers;



use app\models\Word;
use app\models\WordItem;
use app\models\WordPack;
use app\models\WordStat;

class ApiController extends \yii\rest\Controller
{

    public function actionRepeatWords(){
        $model = Word::repeatWords();
        shuffle($model);
        return $model;

    }

    public function actionWordsByPack($id, $type = 'a', $only_new = false, $rep = false){

        $items = [];
        if($type == 'r'){
            $a = WordPack::apiWords($id, 'a', $only_new);
            $b = WordPack::apiWords($id, 'b', $only_new);
            $items = array_merge($a, $b);
        }
        else
            $items = WordPack::apiWords($id, $type, $only_new);
        shuffle($items);
        return $items;
    }

    public function actionAddWordTip(){
        $model = Word::findOne(\Yii::$app->request->post('word_id'));
        if($model){
            $model->tip = \Yii::$app->request->post('tip');
            $model->save();
        }
    }

    public function actionSkipWord(){
        $pack = WordPack::findOne(\Yii::$app->request->post('pack_id'));
        $model = Word::findOne(\Yii::$app->request->post('word_id'));
        if($model){
            $model->skip = 1;
            $model->save();

            $newWord = Word::find()->where([ 'skip' => null])->andWhere(['not in', 'id', $pack->wordArr])->orderBy('RAND()')->one();

            $wordPos = array_search($model->id, $pack->wordArr);
            $pack->wordArr[$wordPos] = $newWord->id;
            $pack->save();

            return $newWord;
        }
    }

    public function actionCheckWord(){
        $model = Word::findOne(\Yii::$app->request->post('word_id'));
        $type = \Yii::$app->request->post('type');
        $isCorrect = \Yii::$app->request->post('correct');

        return $model->answered($isCorrect, $type, \Yii::$app->request->post('repeat'));


    }

}