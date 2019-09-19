<?php
/**
 * Created by PhpStorm.
 * User: York
 * Date: 31.10.2018
 * Time: 22:16
 */

namespace app\components;


use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 *
 * @property array $modelArr
 */
class Config extends Component
{

    private $model;
    private $modelArrData = [];
    private $group;
    private $name;

    public function init()
    {
        parent::init();

        $this->model = \app\models\Config::find()->cache(7200)->all();
        foreach ($this->model as $item)
            $this->modelArrData[$item->group][$item->name] = $item->value;
    }

    public function value($key){
        $this->parseKey($key);
        $dbVal = $this->findDBVal();
        if($dbVal) return $dbVal;
        if(isset(\Yii::$app->params[$this->group][$this->name]))
            return \Yii::$app->params[$this->group][$this->name];
        return false;
    }

    private function findDBVal(){
        if(!isset($this->getModelArr()[$this->group][$this->name]))
            return false;
        return $this->getModelArr()[$this->group][$this->name];
    }


    private function getModelArr(){
        return $this->modelArrData;
    }

    private function parseKey($key)
    {
        list($group, $name) = explode('.', $key);
        $this->group = $group;
        $this->name = $name;
    }


}