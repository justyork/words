<?php


namespace app\models;


use Yii;
use yii\base\Model;

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
        if(!$this->validate()) return false;

        $rows = explode("\n", $this->row);

        foreach ($rows as $row) {
            if(empty($row) || trim($row) == '' || trim($row) == ' ') continue;
            $model = new Word();
            $model->category_id = $this->category_id;
            list($model->word, $model->translate) = explode(';', $row);
            $model->save();
        }

        return true;
    }

}