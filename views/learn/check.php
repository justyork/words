<?php
/* @var $this \yii\web\View */
/* @var $model WordPack */

use app\models\WordPack;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Check words');

$this->params['sidebar'] = [
    ["label" => Yii::t('app', 'Start {type}', ['type' => Yii::t('app', 'A-B')]), "url" => ['learn/start', 'id' => $model->id, 'type' => 'a']],
    ["label" => Yii::t('app', 'Start {type}', ['type' => Yii::t('app', 'B-A')]), "url" => ['learn/start', 'id' => $model->id, 'type' => 'b']],
    ["label" => Yii::t('app', 'Start {type}', ['type' => Yii::t('app', 'Random')]), "url" => ['learn/start', 'id' => $model->id, 'type' => 'r']],
];
$this->params['back_link'] = Url::to(['category/get', 'id' => $model->category_id]);
?>

<learn-check pack_id="<?= $model->id?>"></learn-check>
