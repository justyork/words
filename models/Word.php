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
 * @property int $level_ab
 * @property int $level_ba
 * @property int $ab_series
 * @property int $ba_series
 * @property int $level_ab_date
 * @property int $level_ba_date
 *
 * @property WordCategory $category
 * @property int $user_id [int(11)]
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
            [['category_id', 'created_at', 'updated_at', 'level_ab_date', 'level_ba_date', 'level_ab', 'level_ba',  'ab_series', 'ba_series', 'user_id'], 'integer'],
            [['word', 'translate', 'tip'], 'string', 'max' => 255],
            [['word', 'translate', 'tip'], 'trim'],
            [['skip'], 'boolean'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => WordCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['skip', 'level_ab'], 'default', 'value' => 0]
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
            'level_ab' => Yii::t('app', 'Level'),
            'level_ba' => Yii::t('app', 'Level'),
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

    public function beforeSave($insert)
    {
        if($insert)
            $this->user_id = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }

    public function answered($isCorrect, $type, $isRepeat = false){
        if(is_null($this->level_ab)) $this->level_ab = 0;
        if(is_null($this->level_ba)) $this->level_ab = 0;
        if($isCorrect){
            if($this->canSeriesUpdate($type, $isRepeat)){
                if($type == 'a') $this->ab_series++;
                if($type == 'b') $this->ba_series++;
            }
        }
        else{
            if($type == 'a') $this->ab_series = 0;
            elseif($type == 'b') $this->ba_series = 0;
        }
        $this->nextLevel();
    }

    private function canSeriesUpdate($type, $isRepeat){
        $paramsDay = Yii::$app->params['days_by_level'];
        $isA = $type == 'a';
        $isB = $type == 'b';

        if(($isA && $this->level_ab == 0) || ( $isB && $this->level_ba == 0))
            return true;
        if($isA && $isRepeat && $this->level_ab_date < time() - 86400 * $paramsDay[$this->level_ab]) return true;
        if($isB && $isRepeat && $this->level_ba_date < time() - 86400 * $paramsDay[$this->level_ba]) return true;

        return false;
    }

    private function nextLevel(){
        $firstLevelSeries = Yii::$app->params['first_level_series'];
        $nextLevelSeries = Yii::$app->params['next_level_series'];
        if(($this->level_ab == 0 && $this->ab_series >= $firstLevelSeries) || ($this->level_ab != 0 && $this->ab_series >= $nextLevelSeries)){
            $this->level_ab++;
            $this->ab_series = 0;
            $this->level_ab_date = time();
        }
        if(($this->level_ba == 0 && $this->ba_series >= $firstLevelSeries) || ($this->level_ba != 0 && $this->ba_series >= $nextLevelSeries)){
            $this->level_ba++;
            $this->ba_series = 0;
            $this->level_ba_date = time();
        }

        $this->save();
    }

    public static function repeatWords(){
        $paramsDays = Yii::$app->params['days_by_level'];
        $model = self::find()
            ->where('((level_ab = :level AND level_ab_date < :time) OR (level_ba = :level AND level_ba_date < :time)) OR 
            ((level_ab = :level2 AND level_ab_date < :time2) OR (level_ba = :level2 AND level_ba_date < :time2)) OR 
            ((level_ab = :level3 AND level_ab_date < :time3) OR (level_ba = :level3 AND level_ba_date < :time3)) OR 
            ((level_ab = :level4 AND level_ab_date < :time4) OR (level_ba = :level4 AND level_ba_date < :time4))', [
                ':level' => 1,
                ':time' => time() - 3600 * 24 * $paramsDays[1],
                ':level2' => 2,
                ':time2' => time() - 3600 * 24 * $paramsDays[2],
                ':level3' => 3,
                ':time3' => time() - 3600 * 24 * $paramsDays[3],
                ':level4' => 4,
                ':time4' => time() - 3600 * 24 * $paramsDays[4]
            ])
            ->all();

        $arr = [];
        foreach ($model as $item) {
            $sideArr = $item->getRepeatSide();
            foreach ($sideArr as $side) {
                $m = new WordItem();
                $arr[] = $m->import($item, $side);
            }
        }

        return $arr;
    }

    /**
     * @return array
     */
    public function getRepeatSide(){
        $paramsDay = Yii::$app->params['days_by_level'];
        $list = [];
        if($this->level_ab != 0 && $this->level_ab_date < time() - 86400 * $paramsDay[$this->level_ab])
            $list[] = 'a';
        if($this->level_ba != 0 && $this->level_ba_date < time() - 86400 * $paramsDay[$this->level_ba])
            $list[] = 'b';

        return $list;
    }
}
