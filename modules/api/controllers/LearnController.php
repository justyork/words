<?php
/**
 * Author: yorks
 * Date: 26.10.2019
 */

namespace app\modules\api\controllers;


use app\models\Word;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\rest\Controller;

/**
 * Class LearnController
 * @package app\modules\api\controllers
 */
class LearnController extends Controller
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
                    'actions' => ['count-repeat-words', 'repeat-words', 'repeat'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $data;
    }

    /**
     * @param int $category_id
     * @param int $limit
     * @return array
     */
    public function actionRepeatWords($category_id = 0, $limit = 0)
    {
        $words = Word::repeatWords($category_id);
        shuffle($words);
        
        if ($limit > 0 && count($words) > $limit) {
            $words = array_slice($words, 0, $limit);
        }
        
        return $words;
    }

    /**
     * @return int
     */
    public function actionCountRepeatWords()
    {
        return count(Word::repeatWords());
    }
}
