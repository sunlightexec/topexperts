<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.10.2018
 * Time: 15:29
 */

namespace app\models\helpers;

use yii\helpers\Json;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class Experts extends \app\models\Experts
{

    private $defAddr = [
        'facebook' => '',
        'twitter' => '',
        'youtube' => '',
        'tg_chat' => '',
        'tg_group' => '',
        'discord' => '',
        'reddit' => '',
        'medium' => '',
        'bitcointalk_forum' => '',
    ];

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

    public function prepareAdress()
    {
        return $this->defAddr;
    }


    public function setAddress($value = '{}')
    {
        if(is_array($value)) {
            $this->attributes['address'] = Json::encode($value);
            return $this->attributes['address'];
        }

        return $value;
    }

    public function beforeValidate()
    {
        if(empty($this->address)) $this->address = [];
        if(is_array($this->address)) {
            $this->address = Json::encode($this->address);
        }
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    public static function getList()
    {
        $arCats = self::find()->all();
        return ArrayHelper::map($arCats, 'id', 'name');
    }
}