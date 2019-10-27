<?php
/**
 * Author: yorks
 * Date: 27.10.2019
 */

namespace app\models;

/**
 * Class ActiveRecord
 * @package app\models
 *
 * @property boolean $isOwner
 */
class ActiveRecord extends \yii\db\ActiveRecord
{

    public function getIsOwner(){
        return \Yii::$app->user->id == $this->user_id;
    }

}