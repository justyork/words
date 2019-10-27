<?php

namespace app\modules\api\controllers;


use app\models\Word;
use app\models\WordStat;
use Yii;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class WordController extends Controller
{

    public function behaviors()
    {
        $data = parent::behaviors();
        $data['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['check'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $data;
    }

    protected function verbs()
    {
        $data = parent::verbs();
        $data['check'] = ['POST'];
        return $data;
    }

    /** Проверить слово
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionCheck(){
        $model = Word::findOne(\Yii::$app->request->post('word_id'));
        if(!$model || !$model->isOwner) throw new BadRequestHttpException(Yii::t('app', 'Icorrect request'));

        $model->currentType = \Yii::$app->request->post('type');
        $model->isRepeat = \Yii::$app->request->post('repeat');

        if(\Yii::$app->request->post('correct')) $model->correct();
        else $model->fail();
        $model->save();

        WordStat::addToday();

        return 'OK';
    }

}
