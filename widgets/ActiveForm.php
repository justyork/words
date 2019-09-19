<?php


namespace app\widgets;


class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = 'app\widgets\ActiveField';
    public $options = ['class' => 'ui form'];
}