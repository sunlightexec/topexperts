<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 10.10.2018
 * Time: 22:40
 */

namespace app\models\helpers;

use yii\behaviors\TimestampBehavior;

class Exceptions extends \app\models\Exceptions
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                /*'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),*/
            ],
        ];
    }
}