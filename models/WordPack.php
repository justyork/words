<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "word_pack".
 *
 * @property int $id
 * @property string $items
 * @property int $date
 * @property int $category_id [int(11)]
 *
 * @property int $count
 * @property boolean $isLearned
 * @property Word[] $wordModels
 * @property WordCategory $category
 * @property array $allCounts
 * @property int $user_id [int(11)]
 */
class WordPack extends ActiveRecord
{
    public $wordArr;
    private $_wordModels;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'word_pack';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['items', 'category_id'], 'required'],
            [['items'], 'string'],
            [['date', 'category_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'items' => Yii::t('app', 'Items'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    public function fields()
    {
        $data = parent::fields(); // TODO: Change the autogenerated stub
        unset($data['category_id']);
        unset($data['items']);
        unset($data['user_id']);
        $data['date'] = function (){
            return Yii::$app->formatter->asDate($this->date, 'd MMMM YYYY');
        };
        $data['count'] = function (){
            return $this->allCounts;
        };
        $data['learned'] = function (){
            return $this->isLearned;
        };
        $data['url'] = function (){
            return [
                'check' => Url::to(['/learn/check', 'id' => $this->id]),
                'a' => Url::to(['/learn/start', 'id' => $this->id, 'type' => 'a']),
                'b' => Url::to(['/learn/start', 'id' => $this->id, 'type' => 'b']),
                'r' => Url::to(['/learn/start', 'id' => $this->id, 'type' => 'r']),
            ];
        };

        return $data;
    }

    /**
     * @return int
     */
    public function getCount(){
        return count($this->wordArr);
    }

    /** Получить список кол-ва слов
     * @return array
     */
    public function getAllCounts(){
        return [
            'total' => $this->count,
            'learned' => [
                'a' => count($this->getLearnedWords('a')),
                'b' => count($this->getLearnedWords('b')),
            ]
        ];
    }

    /** Получить выученные слова по стороне
     * @param $side
     * @return array
     */
    public function getLearnedWords($side){
        assert(!in_array($side, ['a', 'b']), Yii::t('app', 'Incorrect side name'));
        $arr = [];
        foreach ($this->wordModels as $item) {
            if($side == 'a' && $item->a_level == 0)  continue;
            if($side == 'b' && $item->b_level == 0)  continue;
            $arr[] = $item;
        }
        return $arr;
    }

    /** Выучено ли слово
     * @return array
     */
    public function getIsLearned(){
        $arr = [
            'a' => true,
            'b' => true,
            'all' => true,
        ];
        foreach ($this->wordModels as $item) {
            if($item->a_level == 0) $arr['a'] = false;
            if($item->b_level == 0) $arr['b'] = false;
        }
        if(!$arr['a'] || !$arr['b']) $arr['all'] = false;

        return $arr;
    }


    /** Поменять слово
     * @param Word $word
     * @return Word|\yii\db\ActiveRecord|null
     */
    public function skipWord(Word $word){
        $word->skip = 1;
        $word->save();

        $newWord = $this->getUnlernedWord();
        $wordPos = array_search($word->id, $this->wordArr);
        $this->wordArr[$wordPos] = $newWord->id;
        $this->save();

        return $newWord;
    }

    /** Получить невыученное слово
     * @return Word|\yii\db\ActiveRecord|null
     */
    private function getUnlernedWord(){
        return $this->category->getUnlearnedWords()
            ->andWhere('skip IS NULL OR skip = 0')
            ->andWhere(['not in', 'id', $this->wordArr])
            ->orderBy('RAND()')
            ->one();
    }


    /**
     * @return \yii\db\ActiveQuery|WordCategory
     */
    public function getCategory(){
        return $this->hasOne(WordCategory::className(), ['id' => 'category_id']);
    }


    public function getWordModels(){
        if(!$this->_wordModels){
            $this->_wordModels = Word::find()->where(['id' => $this->wordArr])->all();
        }
        return $this->_wordModels;
    }
    /**
     * @param $id
     * @param $side
     * @param $only_new
     * @return array
     */
    public static function apiWords($id, $side, $only_new = false){
        $model = WordPack::findOne($id);
        $arr = [];
        foreach ($model->wordModels as $item) {
            if(in_array($side, ['a', 'ab']) && $only_new && $item->a_level != 0) continue;
            if(in_array($side, ['b', 'ba']) && $only_new && $item->b_level != 0) continue;

            $m = new WordItem();
            $arr[] = $m->import($item, $side);
        }
        return $arr;
    }




    public function afterFind()
    {
        parent::afterFind();

        $this->wordArr = json_decode($this->items, true);
        sort($this->wordArr);
    }

    public function beforeSave($insert)
    {
        if(!$insert){
            $this->items = json_encode($this->wordArr);
        }
        else{
            $this->user_id = Yii::$app->user->id;
            $this->date = time();
        }
        return parent::beforeSave($insert);
    }

}
