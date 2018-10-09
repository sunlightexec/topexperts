<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.10.2018
 * Time: 16:32
 */

namespace app\models\helpers;
use yii\behaviors\TimestampBehavior;

class ProjectSynonims extends \app\models\ProjectSynonims
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