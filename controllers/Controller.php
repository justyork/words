<?php
/**
 * Author: yorks
 * Date: 25.03.2020
 */

namespace app\controllers;


class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        \Yii::$app->view->params['sidebar'] = false;
        \Yii::$app->view->params['back_link'] = '/';
        \Yii::$app->view->params['breadcrumbs'] = [];

        return parent::beforeAction($action);
    }
}
