<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 11.10.2018
 * Time: 18:46
 */

namespace app\models\helpers;

use yii\helpers\Json;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class HystoricalData extends \app\models\HystoricalData
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