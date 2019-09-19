<?php


namespace app\controllers;


use app\models\PackForm;
use app\models\WordCategory;
use app\models\WordImportForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{

    public function behaviors()
    {
        return parent::behaviors();
    }

    public function actionIndex()
    {
        $model = WordCategory::find()->all();
        return $this->render('index', compact('model'));
    }

    public function actionGet($id){
        $model = $this->loadModel($id);
        $packForm = new PackForm();
        $packForm->category_id = $id;

        if($packForm->load(\Yii::$app->request->post()) && $packForm->save()){
            return $this->refresh();
        }

        return $this->render('get', compact('model', 'packForm'));
    }
    public function actionCreate(){
        $model = new WordCategory();
        if($model->load(\Yii::$app->request->post()) && $model->save())
            return $this->redirect(['index']);
        return $this->render('form', compact('model'));
    }
    public function actionUpdate($id){
        $model = $this->loadModel($id);
        if($model->load(\Yii::$app->request->post()) && $model->save())
            return $this->redirect(['index']);
        return $this->render('form', compact('model'));
    }
    public function actionDelete($id){
        $model = $this->loadModel($id);
        if($model) $model->delete();
        return $this->redirect(['index']);

    }
    public function actionImport(){
        $model = new WordImportForm();
        if($model->load(\Yii::$app->request->post()) && $model->save())
            return $this->redirect(['get', 'id' => $model->category_id]);
        return $this->render('import', ['model' => $model]);
    }

    private function loadModel($id){
        $model = WordCategory::findOne($id);
        if(!$model) throw new NotFoundHttpException(\Yii::t('app', 'Page not found'));
        return $model;
    }
}