<?php
/**
 * Author: yorks
 * Date: 26.10.2019
 */

namespace app\modules\api\controllers;


use yii\db\ActiveQuery;
use yii\rest\ActiveController;

class CustomActiveController extends ActiveController
{
    /** @var ActiveQuery */
    protected $queryModel;
    protected $limit = 0;


    public function actions()
    {
        $actions = parent::actions();
        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $modelName = $this->modelClass;
        $this->queryModel = $modelName::find();
        $this->queryModel->where(['user_id' => \Yii::$app->user->id]);
    }

    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $this->queryModel,
            'pagination' => ['pageSize' => $this->limit],
        ]);
        return $dataProvider;
    }
}
