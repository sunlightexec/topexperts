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

    public static function getListOfNames()
    {
        $arCats = self::find()->all();
        return ArrayHelper::map($arCats, 'name', 'name');
    }

    public static function setRatings($expert_id)
    {
        $model = self::find()->where(['=', 'id', $expert_id])->one();

        /*$select = 'AVG(IF(project_data.flip >= graduation_ratings.min_star, project_data.flip, "0" )) as flip,' .
            'AVG(IF(project_data.hold >= graduation_ratings.min_star, project_data.hold, "0" )) as hold';*/

        $select = [
            'flipSum' => 'SUM(IF(project_data.flip >= graduation_ratings.min_star, project_data.flip, 0 ))',
            'holdSum' => 'SUM(IF(project_data.hold >= graduation_ratings.min_star, project_data.hold, 0 ))',
            'flipCount' => 'SUM(IF(project_data.flip >= graduation_ratings.min_star, 1, 0 ))',
            'holdCount' => 'SUM(IF(project_data.hold >= graduation_ratings.min_star, 1, 0 ))',
        ];

        $updates = ProjectData::find()
            ->joinWith(['graduation'])
            ->select($select)
            ->where(['=', 'project_data.expert_id', $expert_id])
            ->groupBy('project_data.expert_id')
            ->asArray()
            ->one();

//        print_r($updates);die();

        if(!empty($updates)) {
            $model->flip = $updates['flipCount']==0 ? 0 : round($updates['flipSum'] / $updates['flipCount'],1);
            $model->hold = $updates['holdCount']==0 ? 0 : round($updates['holdSum'] / $updates['holdCount'],1);
            $model->save();
        }
    }
}