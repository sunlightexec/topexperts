<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 10.10.2018
 * Time: 21:27
 */

namespace app\models;


class BaseModel extends \yii\db\ActiveRecord
{
    public static function getStatusList()
    {
//        return [
//            'id' => 1, 'name' => 'Imported',
//            'id' => 2, 'name' => 'Edited',
//            'id' => 10, 'name' => 'Imported',
//        ];
        return [
             1 => 'Imported1',
             2 => 'Edited',
            10 => 'Imported2',
        ];
    }
}