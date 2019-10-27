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
            $this->level = $model->a_level ?? 0;
            $this->series = $model->a_series ?? 0;
        }
        else{
            $this->word = $model->translate;
            $this->translate = $model->word;
            $this->level = $model->b_level ?? 0;
            $this->series = $model->b_series ?? 0;
        }
        $this->series_need = $this->level == 0 || $this->level == null ? \Yii::$app->params['first_level_series'] : \Yii::$app->params['next_level_series'];

        return $this;
    }

}