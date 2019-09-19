<?php


namespace app\controllers;


use app\models\PackForm;
use app\models\Word;
use app\models\WordCategory;
use app\models\WordImportForm;
use app\models\WordPack;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class WordController extends Controller
{

    public function actionIndex($id){

        $model = WordCategory::findOne($id);

        return $this->render('index', ['model' => $model]);
    }
    public function actionDelete($id){
        $model = $this->loadModel($id);
        $id = $model->category_id;
        if($model) $model->delete();
        return $this->redirect(['index', 'id' => $id]);
    }
    public function actionUpdate($id){
        $model = $this->loadModel($id);
        if($model->load(\Yii::$app->request->post()) && $model->save())
            return $this->redirect(['index', 'id' => $model->category_id]);

        return $this->render('form', ['model' => $model]);
    }
    public function actionCreate($id){
        $model = new Word();
        $model->category_id = $id;
        if($model->load(\Yii::$app->request->post()) && $model->save())
            return $this->redirect(['index', 'id' => $model->category_id]);
        return $this->render('form', ['model' => $model]);
    }
    public function actionSkip(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->loadModel(\Yii::$app->request->post('id'));
        $model->skip = !$model->skip;
        if(!$model->save())
            var_dump($model->errors);


        return ['skip' => $model->skip];
    }

    private function loadModel($id){
        $model = Word::findOne($id);
        if(!$model) throw new NotFoundHttpException(\Yii::t('app', 'Page not found'));
        return $model;
    }
}