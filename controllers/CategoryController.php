<?php


namespace app\controllers;


use app\models\PackForm;
use app\models\WordCategory;
use app\models\WordImportForm;
use app\models\WordPack;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'get', 'create', 'update', 'delete', 'import', 'merge', 'delete-packs'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = WordCategory::findAllByUser();
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
        $model = WordCategory::findOneByUser($id);
        if(!$model) throw new NotFoundHttpException(\Yii::t('app', 'Page not found'));
        return $model;
    }

    public function actionMerge($items){
        $arr = explode(',', $items);
        $model = WordPack::find()->where(['id' => $arr])->all();
        $first = $model[0];
        $ids = [];
        foreach ($model as $item){
            $ids = array_merge($ids, $item->wordArr);
            if($item->id !== $first->id)
                $item->delete();
        }
        $first->wordArr = $ids;
        $first->save();
        return $this->redirect(['get', 'id' => $first->category_id]);
    }

    public function actionDeletePacks($items){
        $arr = explode(',', $items);
        $model = WordPack::find()->where(['id' => $arr])->all();
        $cat_id = $model[0]->category_id;
        foreach ($model as $item) {
            $item->delete();
        }
        return $this->redirect(['get', 'id' => $cat_id]);

    }
}