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
        $wordsCond = Word::find();
        if($this->onlyNew){
            $wordsCond->where(['is', 'level', null])->orWhere(['level' => 0]);
        }
        $wordsCond->andWhere(['is', 'skip', null]);
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
}