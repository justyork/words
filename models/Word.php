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
 * @property int $a_level
 * @property int $b_level
 * @property int $a_series
 * @property int $b_series
 * @property int $a_level_date
 * @property int $b_level_date
 *
 * @property WordCategory $category
 * @property int $user_id [int(11)]
 * @property int level
 * @property int levelDate
 * @property array $repeatSide
 * @property int series
 */
class Word extends ActiveRecord
{

    public $currentType;
    public $isRepeat;

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
            [['word', 'translate'], 'required'],
            [['category_id', 'created_at', 'updated_at', 'a_level_date', 'b_level_date', 'a_level', 'b_level', 'a_series', 'b_series', 'user_id'], 'integer'],
            [['word', 'translate', 'tip'], 'string', 'max' => 255],
            [['word', 'translate', 'tip'], 'trim'],
            [['skip'], 'boolean'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => WordCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['skip', 'a_level'], 'default', 'value' => 0]
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
            'a_level' => Yii::t('app', 'Level'),
            'b_level' => Yii::t('app', 'Level'),
            'a_series' => Yii::t('app', 'Ab Series'),
            'b_series' => Yii::t('app', 'Ba Series'),
        ];
    }

    public static function find()
    {
        return parent::find()->where(['user_id' => Yii::$app->user->id]);
    }

    public function afterFind()
    {
        parent::afterFind();
        if ($this->skip === null) $this->skip = false;
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
        if ($insert)
            $this->user_id = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }


    /** Получить слова для повторения
     * @param bool $category_id
     * @return array
     */
    public static function repeatWords($category_id = false)
    {
        $paramsDays = Yii::$app->params['days_by_level'];
        $q = self::find()
            ->where('((a_level = :level AND a_level_date < :time) OR (b_level = :level AND b_level_date < :time)) OR 
            ((a_level = :level2 AND a_level_date < :time2) OR (b_level = :level2 AND b_level_date < :time2)) OR 
            ((a_level = :level3 AND a_level_date < :time3) OR (b_level = :level3 AND b_level_date < :time3)) OR 
            ((a_level = :level4 AND a_level_date < :time4) OR (b_level = :level4 AND b_level_date < :time4)) OR 
            ((a_level = :level5 AND a_level_date < :time5) OR (b_level = :level5 AND b_level_date < :time5)) OR 
            ((a_level = :level6 AND a_level_date < :time6) OR (b_level = :level6 AND b_level_date < :time6))', [
                ':level' => 1,
                ':time' => time() - 3600 * 24 * $paramsDays[1],
                ':level2' => 2,
                ':time2' => time() - 3600 * 24 * $paramsDays[2],
                ':level3' => 3,
                ':time3' => time() - 3600 * 24 * $paramsDays[3],
                ':level4' => 4,
                ':time4' => time() - 3600 * 24 * $paramsDays[4]
                ':level5' => 5,
                ':time5' => time() - 3600 * 24 * $paramsDays[5]
                ':level6' => 6,
                ':time6' => time() - 3600 * 24 * $paramsDays[6]
            ])
            ->andWhere(['user_id' => Yii::$app->user->id]);
        if ($category_id)
            $q->andWhere(['category_id' => $category_id]);

        $model = $q->all();

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

    /** Получить список сторон для повторения
     * @return array
     */
    public function getRepeatSide()
    {
        $paramsDay = Yii::$app->params['days_by_level'];
        $list = [];
        if ($this->a_level != 0 && $this->a_level_date < time() - 86400 * $paramsDay[$this->a_level])
            $list[] = 'a';
        if ($this->b_level != 0 && $this->b_level_date < time() - 86400 * $paramsDay[$this->b_level])
            $list[] = 'b';

        return $list;
    }


    /**
     * Верный ответ
     */
    public function correct()
    {
        if ($this->canSeriesUp())
            $this->series++;

        if ($this->canLevelUp()) {
            $this->level++;
            $this->levelDate = time();
            $this->series = 0;
        }
    }

    /**
     * Не верный ответ
     */
    public function fail()
    {
        $this->series = 0;
        if ($this->level > 1)
            $this->level--;
    }

    /** Можно ли повысить серию
     * @return bool
     */
    private function canSeriesUp()
    {
        $countDaysToTakeWord = Yii::$app->params['days_by_level'];
        if ($this->level == 0) return true;
        if ($this->isRepeat && $this->levelDate < time() - 86400 * $countDaysToTakeWord[$this->level])
            return true;

        return false;
    }

    /** Можем ли мы повысить уровень
     * @return bool
     */
    private function canLevelUp()
    {
        $firstLevelSeries = Yii::$app->params['first_level_series'];
        $nextLevelSeries = Yii::$app->params['next_level_series'];
        if ($this->level == 0 && $this->series >= $firstLevelSeries)
            return true;
        if ($this->level > 0 && $this->series >= $nextLevelSeries)
            return true;
        return false;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        $name = $this->currentType . '_level';
        return $this->$name;
    }

    /**
     * @param $val
     */
    public function setLevel($val)
    {
        $name = $this->currentType . '_level';
        $this->$name = $val;
    }

    /**
     * @return mixed
     */
    public function getLevelDate()
    {
        $name = $this->currentType . '_level_date';
        return $this->$name;
    }

    /**
     * @param $val
     */
    public function setLevelDate($val)
    {
        $name = $this->currentType . '_level_date';
        $this->$name = $val;
    }

    /**
     * @return mixed
     */
    public function getSeries()
    {
        $name = $this->currentType . '_series';
        return $this->$name;
    }

    /**
     * @param $val
     */
    public function setSeries($val)
    {
        $name = $this->currentType . '_series';
        $this->$name = $val;
    }


    /**
     * НИЖЕ ТРЕШ НАДО ПЕРЕДЕЛАТЬ
     *
     *
     * @param $isCorrect
     * @param $type
     * @param bool $isRepeat
     * @return string
     */


    public function answered($isCorrect, $type, $isRepeat = false)
    {
        if (is_null($this->a_level)) $this->a_level = 0;
        if (is_null($this->b_level)) $this->a_level = 0;
        if ($this->canSeriesUpdate($type, $isRepeat)) {
            if ($isCorrect) {
                if ($type == 'a' || $type == 'ab') $this->a_series++;
                if ($type == 'b' || $type == 'ba') $this->b_series++;
            } else {
                if ($type == 'a' || $type == 'ab') {
                    $this->a_series = 0;
                    $this->a_level = $this->a_level > 1 ? $this->a_level - 1 : 1;
                }
                if ($type == 'b' || $type == 'ba') {
                    $this->b_series = 0;
                    $this->b_level = $this->b_level > 1 ? $this->b_level - 1 : 1;
                }
            }
        }
        return $this->nextLevel();
    }

    private function canSeriesUpdate($type, $isRepeat)
    {
        $paramsDay = Yii::$app->params['days_by_level'];
        $isA = $type == 'a' || $type == 'ab';
        $isB = $type == 'b' || $type == 'ba';

        if (($isA && $this->a_level == 0) || ($isB && $this->b_level == 0))
            return true;
        if ($isA && $isRepeat && $this->a_level_date < time() - 86400 * $paramsDay[$this->a_level]) return true;
        if ($isB && $isRepeat && $this->b_level_date < time() - 86400 * $paramsDay[$this->b_level]) return true;

        return false;
    }

    private function nextLevel()
    {
        $firstLevelSeries = Yii::$app->params['first_level_series'];
        $nextLevelSeries = Yii::$app->params['next_level_series'];
        if (($this->a_level == 0 && $this->a_series >= $firstLevelSeries) || ($this->a_level > 0 && $this->a_series >= $nextLevelSeries)) {
            $this->a_level += 1;
            $this->a_series = 0;
            $this->a_level_date = time();
        }

        if (($this->b_level == 0 && $this->b_series >= $firstLevelSeries) || ($this->b_level > 0 && $this->b_series >= $nextLevelSeries)) {
            $this->b_level += 1;
            $this->b_series = 0;
            $this->b_level_date = time();
        }

        if ($this->save()) {
            WordStat::addToday();
            return 'OK';
        }
        var_dump($this->errors);
    }


}
