<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "word_pack".
 *
 * @property int $id
 * @property string $items
 * @property int $date
 * @property int $category_id [int(11)]
 *
 * @property int $count
 * @property Word[] $wordModels
 * @property int $user_id [int(11)]
 */
class WordPack extends \yii\db\ActiveRecord
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
        else
            $this->user_id = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }

    /**
     * @return int
     */
    public function getCount(){
        return count($this->wordArr);
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
     * @return array
     */
    public static function apiWords($id, $side){
        $model = WordPack::findOne($id);
        $arr = [];
        foreach ($model->wordModels as $item) {
            $m = new WordItem();
            $arr[] = $m->import($item, $side);
        }
        return $arr;
    }
}
