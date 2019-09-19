<?php
/* @var $this \yii\web\View */

use app\models\WordPack;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Learn words');
/* @var $model WordPack */

$arr = [];
if($_GET['type'] != 'ab')
    $arr[] = ["label" => Yii::t('app', 'Start {type}', ['type' => 'AB']), "url" => ['learn/start', 'id' => $model->id, 'type' => 'ab']];
if($_GET['type'] != 'ba')
    $arr[] = ["label" => Yii::t('app', 'Start {type}', ['type' => 'BA']), "url" => ['learn/start', 'id' => $model->id, 'type' => 'ba']];
if($_GET['type'] != 'r')
    $arr[] = ["label" => Yii::t('app', 'Start {type}', ['type' => 'Rand']), "url" => ['learn/start', 'id' => $model->id, 'type' => 'r']];

$arr[] = ["label" => Yii::t('app', 'Show words'), "url" => ['learn/check', 'id' => $model->id]];

$this->params['sidebar'] = $arr;
$this->params['back_link'] = Url::to(['category/get', 'id' => $model->category_id]);
?>


<learn pack_id="<?= $model->id?>" type="<?= Yii::$app->request->get('type')?>"></learn>