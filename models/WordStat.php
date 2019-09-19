<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "word_stat".
 *
 * @property int $id
 * @property int $date
 * @property int $count_words
 */
class WordStat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'word_stat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'count_words'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
            'count_words' => Yii::t('app', 'Count Words'),
        ];
    }

    public static function addToday(){
        $model = WordStat::find()->where(['>', 'date', strtotime('today 00:00:00')])->one();
        if(!$model){
            $model = new WordStat();
            $model->date = time();
            $model->count_words = 0;
        }
        $model->count_words = $model->count_words + 1;
        $model->save();
        return $model;
    }

}
