<?php


namespace app\models;


use Yii;
use yii\base\Model;
use yii\db\QueryBuilder;
use yii\debug\models\search\Db;

class WordImportForm extends Model
{
    public $row;
    public $category_id;
    public $separator;

    public function rules()
    {
        return [
            ['row', 'safe'],
            ['category_id', 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => WordCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            ['separator', 'string'],
            ['separator', 'in', 'range' => ['tab', 'slash', 'semicolon'], 'message' => Yii::t('app', 'Invalid separator')],
            ['separator', 'default', 'value' => 'semicolon'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'row' => Yii::t('app', 'Row'),
            'category_id' => Yii::t('app', 'Category'),
            'separator' => Yii::t('app', 'Separator'),
        ];
    }

    public function getSeparatorValue()
    {
        switch ($this->separator) {
            case 'tab':
                return "\t";
            case 'slash':
                return '//';
            case 'semicolon':
                return ';';
            default:
                return ';';
        }
    }

    public function getSeparatorLabel($value)
    {
        $labels = [
            'tab' => Yii::t('app', 'Tab'),
            'slash' => '//',
            'semicolon' => ';',
        ];
        return isset($labels[$value]) ? $labels[$value] : $value;
    }

    public static function getSeparatorOptions()
    {
        return [
            'tab' => Yii::t('app', 'Tab'),
            'slash' => '//',
            'semicolon' => ';',
        ];
    }

    public function save()
    {
        if (!$this->validate()) return false;

        $rows = explode("\n", $this->row);

        $rowsToInsert = [];
        $user_id = Yii::$app->user->id;
        $time = time();

        $separator = $this->getSeparatorValue();

        foreach ($rows as $row) {
            if (empty($row) || trim($row) == '' || trim($row) == ' ') continue;

            $parts = explode($separator, $row, 2);
            if (count($parts) < 2) continue;

            $word = trim($parts[0]);
            $translate = trim($parts[1]);

            $rowsToInsert[] = [
                $word,
                $translate,
                $this->category_id,
                $user_id,
                $time,
                $time,
            ];
        }

        if (!empty($rowsToInsert)) {
            Yii::$app->db->createCommand()
                ->batchInsert(
                    'word',
                    ['word', 'translate', 'category_id', 'user_id', 'created_at', 'updated_at'],
                    $rowsToInsert
                )
                ->execute();
        }

        return true;
    }

}
