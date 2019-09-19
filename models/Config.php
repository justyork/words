<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property string $group
 * @property string $name
 * @property string $description
 * @property string $value
 * @property int $type
 * @property string $params
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'params'], 'string'],
            [['type'], 'integer'],
            [['group', 'name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('field', 'ID'),
            'group' => Yii::t('field', 'Group'),
            'name' => Yii::t('field', 'Name'),
            'description' => Yii::t('field', 'Description'),
            'value' => Yii::t('field', 'Value'),
            'type' => Yii::t('field', 'Type'),
            'params' => Yii::t('field', 'Params'),
        ];
    }

    public function field(){
        $f = Html::textInput('Config['.$this->name.']', $this->value, ['class' => 'form-control']);

        return $f;
    }
}
