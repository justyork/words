<?php

use app\models\PackForm;
use app\models\WordCategory;
use app\widgets\ActiveForm;
use app\widgets\Checkbox;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $model WordCategory */
/* @var $packForm PackForm */
$this->params['back_link'] = Url::to(['category/index']);
$this->title = $model->title;
?>

<category :id="<?= $_GET['id'];?>"></category>
