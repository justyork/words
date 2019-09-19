<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "word_info".
 *
 * @property int $id
 * @property int $ab_view
 * @property int $ab_correct
 * @property int $ba_view
 * @property int $ba_correct
 * @property int $random_view
 * @property int $random_correct
 * @property int $ab_last
 * @property int $ba_last
 * @property int $random_last
 */
class WordInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'word_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ab_view', 'ab_correct', 'ba_view', 'ba_correct', 'random_view', 'random_correct', 'ab_last', 'ba_last', 'random_last'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ab_view' => Yii::t('app', 'Ab View'),
            'ab_correct' => Yii::t('app', 'Ab Correct'),
            'ba_view' => Yii::t('app', 'Ba View'),
            'ba_correct' => Yii::t('app', 'Ba Correct'),
            'random_view' => Yii::t('app', 'Random View'),
            'random_correct' => Yii::t('app', 'Random Correct'),
            'ab_last' => Yii::t('app', 'Ab Last'),
            'ba_last' => Yii::t('app', 'Ba Last'),
            'random_last' => Yii::t('app', 'Random Last'),
        ];
    }
}
