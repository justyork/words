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

    public function rules()
    {
        return [
            ['row', 'safe'],
            ['category_id', 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => WordCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'row' => Yii::t('app', 'Row'),
            'category_id' => Yii::t('app', 'Category'),
        ];
    }

    public function save()
    {
        if (!$this->validate()) return false;

        $rows = explode("\n", $this->row);

        $rowsToInsert = [];
        $user_id = Yii::$app->user->id;
        $time = time();

        foreach ($rows as $row) {
            if (empty($row) || trim($row) == '' || trim($row) == ' ') continue;

            list($word, $translate) = explode($_ENV['IMPORT_SEPARATOR'], $row);
            $word = trim($word);
            $translate = trim($translate);

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
