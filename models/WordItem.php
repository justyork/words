<?php
/**
 * Author: yorks
 * Date: 05.10.2019
 */

namespace app\models;


class WordItem
{
    public $id;
    public $word;
    public $translate;
    public $level;
    public $type;
    public $series;
    public $series_need;
    public $tip;

    public function import(Word $model, $side){
        $this->id = $model->id;
        $this->type = $side;
        $this->tip = $model->tip;

        if($side == 'a' || $side == 'ab'){
            $this->word = $model->word;
            $this->translate = $model->translate;
            $this->level = $model->level_ab;
            $this->series = $model->ab_series;
        }
        else{
            $this->word = $model->translate;
            $this->translate = $model->word;
            $this->level = $model->level_ba;
            $this->series = $model->ba_series;
        }
        $this->series_need = $this->level == 0 ? \Yii::$app->params['first_level_series'] : \Yii::$app->params['next_level_series'];

        return $this;
    }

}