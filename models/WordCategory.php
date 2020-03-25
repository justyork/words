<?php

namespace app\models;

use http\Url;
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
 * @property Word[] $unlearnedWords
 * @property WordPack[] $packs
 * @property array $reviewWords
 * @property int $countReviewWords
 * @property int $user_id [int(11)]
 */
class WordCategory extends ActiveRecord
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
            [['title'], 'required'],
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

    public function fields()
    {
        $data = parent::fields();
        unset($data['last_update']);
        unset($data['id']);
        unset($data['user_id']);
        $data['url'] = function () {
            return \yii\helpers\Url::to(['/category/get', 'id' => $this->id]);
        };
        $data['count'] = function () {
            return $this->getWords()->count();
        };
        $data['has_review'] = function () {
            return $this->getCountReviewWords();
        };
        $data['repeatUrl'] = function () {
            return '/learn/repeat?category_id=' . $this->id;
        };
        return $data;
    }

    public function extraFields()
    {
        return ['packs'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWords()
    {
        return $this->hasMany(Word::className(), ['category_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getReviewWords()
    {
        return Word::repeatWords($this->id);
    }

    /**
     * @return int
     */
    public function getCountReviewWords()
    {
        return count($this->getReviewWords());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacks()
    {
        return $this->hasMany(WordPack::className(), ['category_id' => 'id'])->orderBy('date DESC');
    }


    public function beforeSave($insert)
    {
        if ($insert)
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

    public static function findAllByUser()
    {
        return WordCategory::find()->where(['user_id' => Yii::$app->user->id])->all();
    }

    public static function findOneByUser($id)
    {
        return WordCategory::findOne(['user_id' => Yii::$app->user->id, 'id' => $id]);
    }

    /**
     * @return \yii\db\ActiveQuery | Word[]
     */
    public function getUnlearnedWords()
    {
        return $this->getWords()
            ->andWhere('a_level IS NULL OR a_level = 0')
            ->andWhere('b_level IS NULL OR b_level = 0')
            ->andWhere('a_series IS NULL OR a_series = 0')
            ->andWhere('b_series IS NULL OR b_series = 0')
            ->andWhere('skip IS NULL OR skip = 0');
    }
}
