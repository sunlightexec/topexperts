<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 10.10.2018
 * Time: 19:39
 */

namespace app\models\helpers;

use yii\behaviors\TimestampBehavior;

class Projects extends \app\models\Projects
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

    public function beforeValidate()
    {
        /*die(print_r($this->START_ICO));
        if(!empty($this->START_ICO))
            $this->START_ICO = strtotime($this->START_ICO );
        if(!empty($this->END_ICO))
            $this->END_ICO = strtotime($this->END_ICO);*/

        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }
}