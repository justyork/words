<?php


namespace app\controllers;



use app\models\Word;
use app\models\WordPack;
use app\models\WordStat;

class ApiController extends \yii\rest\Controller
{

    public function actionWordsByPack($id){

        $model = WordPack::findOne($id);
        $items = $model->wordModels;
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
            $pack->wordArr[$wordPos] = $pack->wordModels[$wordPos]->id;
            $pack->save();

            return $newWord;
        }
    }

    public function actionCheckWord(){
        $model = Word::findOne(\Yii::$app->request->post('word_id'));
        $type = \Yii::$app->request->post('type');
        $isCorrect = \Yii::$app->request->post('correct');

        $model->answered($isCorrect, $type);
        $model->save();
        WordStat::addToday();
    }

}