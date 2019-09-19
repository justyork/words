<?php
/* @var $this \yii\web\View */
/* @var $model WordPack */

use app\models\WordPack;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Check words');

$this->params['sidebar'] = [
    ["label" => Yii::t('app', 'Start {type}', ['type' => 'AB']), "url" => ['learn/start', 'id' => $model->id, 'type' => 'ab']],
    ["label" => Yii::t('app', 'Start {type}', ['type' => 'BA']), "url" => ['learn/start', 'id' => $model->id, 'type' => 'ba']],
    ["label" => Yii::t('app', 'Start {type}', ['type' => 'Rand']), "url" => ['learn/start', 'id' => $model->id, 'type' => 'r']],
];
$this->params['back_link'] = Url::to(['category/get', 'id' => $model->category_id]);
?>

<learn-check pack_id="<?= $model->id?>"></learn-check>