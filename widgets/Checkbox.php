<?php


namespace app\widgets;


use yii\helpers\Html;
use yii\widgets\InputWidget;

class Checkbox extends InputWidget
{

    public function run()
    {
        $ret = Html::beginTag('div', ['class' => 'ui checkbox']);
            $ret .= Html::activeCheckbox($this->model, $this->attribute, ['label' => false]);
            $ret .= Html::activeLabel($this->model, $this->attribute);
        $ret .= Html::endTag('div');
        echo  $ret;
    }
}