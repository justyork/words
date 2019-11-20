<?php
/**
 * Author: yorks
 * Date: 26.10.2019
 */

namespace app\modules\api\controllers;


use yii\rest\ActiveController;

class StatController extends CustomActiveController
{

    public $modelClass = 'app\models\WordStat';



    public function prepareDataProvider()
    {
        $this->limit = 7;
        return parent::prepareDataProvider(); // TODO: Change the autogenerated stub
    }
}