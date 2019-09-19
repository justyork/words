<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "word".
 *
 * @property int $id
 * @property int $category_id
 * @property string $word
 * @property string $translate
 * @property string $tip
 * @property int $created_at
 * @property int $updated_at
 * @property int $skip
 * @property int $level
 * @property int $ab_series
 * @property int $ba_series
 *
 * @property WordCategory $category
 */
class Word extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [TimestampBehavior::className()];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'word';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'created_at', 'updated_at', 'level', 'ab_series', 'ba_series'], 'integer'],
            [['word', 'translate', 'tip'], 'string', 'max' => 255],
            [['skip'], 'boolean'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => WordCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'word' => Yii::t('app', 'Word'),
            'translate' => Yii::t('app', 'Translate'),
            'tip' => Yii::t('app', 'Tip'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'skip' => Yii::t('app', 'Skip'),
            'level' => Yii::t('app', 'Level'),
            'ab_series' => Yii::t('app', 'Ab Series'),
            'ba_series' => Yii::t('app', 'Ba Series'),
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        if($this->ba_series === null) $this->ba_series = 0;
        if($this->ab_series === null) $this->ab_series = 0;
        if($this->skip === null) $this->skip = false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(WordCategory::className(), ['id' => 'category_id']);
    }

    public function answered($isCorrect, $type){
        if($isCorrect){
            if($type == 'a') $this->ab_series++;
            elseif($type == 'b') $this->ba_series++;
        }
        else{
            if($type == 'a') $this->ab_series = 0;
            elseif($type == 'b') $this->ba_series = 0;
        }
        $this->nextLevel();
    }

    private function nextLevel(){
        $firstLevelSeries = Yii::$app->params['first_level_series'];
        $nextLevelSeries = Yii::$app->params['next_level_series'];
        if(($this->level == 0 && $this->ab_series == $firstLevelSeries && $this->ba_series == $firstLevelSeries)
            || ($this->level != 0 && $this->ab_series == $nextLevelSeries && $this->ba_series == $nextLevelSeries)
        ){
            $this->level++;
            $this->ab_series = 0;
            $this->ba_series = 0;
        }
    }
}
