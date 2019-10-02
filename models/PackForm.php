<?php


namespace app\models;


use Yii;
use yii\base\Model;

class PackForm extends Model
{

    public $count = '20';
    public $onlyNew = true;
    public $category_id;


    public function rules()
    {
        return [
            [['count', 'category_id'], 'integer'],
            ['onlyNew', 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'count' => Yii::t('app', 'Count'),
            'onlyNew' => Yii::t('app', 'Only new'),
        ];
    }

    public function save(){
        if(!$this->validate()) return false;


        $model = new WordPack();
        $wordArr = [];
        $wordsCond = Word::find()
            ->where(['category_id' => $this->category_id])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere('skip <> 1');
        if($this->onlyNew){
            $activeIdList = $this->getWordsInPacks();
            if($activeIdList)
                $wordsCond = $wordsCond->andWhere(['NOT IN', 'id', $activeIdList]);
        }

        $words = $wordsCond->all();
        shuffle($words);
        $items = array_slice($words, 0, $this->count);
        foreach ($items as $item)
            $wordArr[] = $item->id;

        $model->items = json_encode($wordArr);
        $model->date = time();
        $model->category_id = $this->category_id;
        $model->save();

        return true;
    }

    private function getWordsInPacks(){
        $model = WordCategory::findOneByUser($this->category_id);
        $idList = [];
        foreach ($model->packs as $item) {
            $idList = array_merge($item->wordArr, $idList);
        }
        return $idList;
    }
}