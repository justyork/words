<?php


namespace app\models;


use Yii;
use yii\base\Model;

class PackForm extends Model
{

    public $count = '20';
    public $onlyNew = true;
    public $category_id;
    /** @var WordCategory */
    public $category;


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

    /** Добавить пачку
     * @return bool
     */
    public function save(){
        if(!$this->validate()) return false;

        $activeIdList = $this->getWordsInPacks();

        $words = $this->category->getUnlearnedWords()
            ->andWhere(['NOT IN', 'id', $activeIdList])
            ->orderBy('RAND()')
            ->limit($this->count)
            ->all();

        $wordArr = [];
        foreach ($words as $item)
            $wordArr[] = $item->id;

        $model = new WordPack();
        $model->items = json_encode($wordArr);
        $model->category_id = $this->category_id;
        $model->save();
        return true;
    }

    /**
     * @return array
     */
    private function getWordsInPacks(){
        $model = WordCategory::findOneByUser($this->category_id);
        $idList = [];
        foreach ($model->packs as $item) {
            $idList = array_merge($item->wordArr, $idList);
        }
        return $idList;
    }
}