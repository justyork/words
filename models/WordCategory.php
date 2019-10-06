<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "word_category".
 *
 * @property int $id
 * @property string $title
 * @property int $last_update
 *
 * @property Word[] $words
 * @property WordPack[] $packs
 * @property int $user_id [int(11)]
 */
class WordCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'word_category';
    }

    public static function map()
    {
        return ArrayHelper::map(self::findAllByUser(), 'id', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_update', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'last_update' => 'Last Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWords()
    {
        return $this->hasMany(Word::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacks(){
        return $this->hasMany(WordPack::className(), ['category_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if($insert)
            $this->user_id = Yii::$app->user->id;
        $this->last_update = time();
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        foreach ($this->packs as $item) $item->delete();
        foreach ($this->words as $item) $item->delete();
        return parent::beforeDelete();
    }

    public static function findAllByUser(){
        return WordCategory::find()->where(['user_id' => Yii::$app->user->id])->all();
    }
    public static function findOneByUser($id){
        return WordCategory::findOne(['user_id' => Yii::$app->user->id, 'id' => $id]);
    }
}
