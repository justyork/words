<?php

namespace app\modules\api\controllers;


use app\models\PackForm;
use app\models\Word;
use app\models\WordCategory;
use app\models\WordPack;
use Yii;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

/**
 * Class PackController
 * @package app\modules\api\controllers
 */
class PackController extends Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        $data = parent::behaviors();
        $data['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['create', 'get', 'skip-word', 'delete'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $data;
    }


    /**
     * @return array
     */
    protected function verbs()
    {
        $data = parent::verbs();
        $data['create'] = ['POST'];
        $data['skip-word'] = ['POST'];
        $data['delete'] = ['POST'];
        return $data;
    }

    /** Добавить пачку
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $category_id = \Yii::$app->request->post('category_id');
        $category = WordCategory::findOne($category_id);
        if (!$category || !$category->isOwner) throw new BadRequestHttpException();

        $model = new PackForm();
        $model->category = $category;
        $model->count = \Yii::$app->request->post('count');
        $model->category_id = $category_id;
        if ($model->save()) return 'OK';
    }

    /** Получить слова из пачки
     * @param $id
     * @param string $type
     * @param bool $new
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionGet($id, $type = 'a', $new = false)
    {
        $model = WordPack::findOne($id);
        if (!$model || !$model->isOwner) throw new BadRequestHttpException(Yii::t('app', 'Bad request'));

        $data = WordPack::apiWords($id, $type, $new);
        if ($type)
            shuffle($data);
        return $data;

    }

    /** Поменять слово
     * @throws BadRequestHttpException
     */
    public function actionSkipWord()
    {
        $model = Word::findOne(Yii::$app->request->post('word_id'));
        if (!$model || !$model->isOwner) throw new BadRequestHttpException(Yii::t('app', 'Bad request'));

        $pack = WordPack::findOne(Yii::$app->request->post('pack_id'));
        if (!$pack || !$pack->isOwner) throw new BadRequestHttpException(Yii::t('app', 'Bad request'));

        return $pack->skipWord($model);
    }


    /** Удалить пачку
     * @return string
     * @throws BadRequestHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        $model = WordPack::findOne(Yii::$app->request->post('id'));
        if (!$model || !$model->isOwner) throw new BadRequestHttpException(Yii::t('app', 'Bad request'));

        $model->delete();
        return 'OK';
    }

}
