<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 10.10.2018
 * Time: 19:26
 */

namespace app\models\helpers;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Categories extends \app\models\Categories
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

    public static function check($name)
    {
        $model = self::find()->where(['=', 'name', $name])->one();
        if(!empty($model)) {
            return $model->id;
        } else {
            $model = new self;
            $model->name = $name;
            if(!$model->save()) die(print_r($model->errors));
            return $model->id;
        }
    }

    public static function getList()
    {
        $arCats = self::find()->all();
        return ArrayHelper::map($arCats, 'id', 'name');
    }
}