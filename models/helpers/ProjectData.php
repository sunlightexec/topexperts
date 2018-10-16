<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 10.10.2018
 * Time: 20:47
 */

namespace app\models\helpers;

use yii\behaviors\TimestampBehavior;

class ProjectData extends \app\models\ProjectData
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

    public function getRating()
    {

    }
}