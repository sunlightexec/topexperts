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
use app\components\jobs\RatingExpertJob;
use app\components\jobs\RatingProjectJob;

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
        $fieldFlip = 'flip_all';
        $fieldFlip1 = 'project_data.flip';
//        $fieldFlip = 'flip_12';
//        $fieldFlip = 'flip_3';
        $fieldHold = 'hold_all';
        $fieldHold1 = 'project_data.hold';
//        $fieldHold = 'hold_12';
//        $fieldHold = 'hold_3';


        $model = self::find()->where(['=', 'id', $expert_id])->one();

        /*$select = 'AVG(IF(project_data.flip >= graduation_ratings.min_star, project_data.flip, "0" )) as flip,' .
            'AVG(IF(project_data.hold >= graduation_ratings.min_star, project_data.hold, "0" )) as hold';*/

        $selectFlip = [
            'flipSum' => 'SUM(IF(projects.Scam IS NOT NULL OR (projects.flip_all>0 AND '.$fieldFlip1.' >= IF(project_data.max_value > 0, project_data.max_value, graduation_ratings.min_star)), projects.'.$fieldFlip.', 0 ))',
//            'holdSum' => 'SUM(IF(projects.hold_all >= IF(project_data.max_value > 0, project_data.max_value, graduation_ratings.min_star), projects.hold_all, 0 ))',
            'flipCount' => 'SUM(IF(projects.Scam IS NOT NULL OR (projects.flip_all>0 AND '.$fieldFlip1.' >= IF(project_data.max_value > 0, project_data.max_value, graduation_ratings.min_star)), 1, 0 ))',
//            'holdCount' => 'SUM(IF(projects.hold_all >= IF(project_data.max_value > 0, project_data.max_value, graduation_ratings.min_star), 1, 0 ))',
        ];

        $selectHold = [
//            'flipSum' => 'SUM(IF(projects.flip_all >= IF(project_data.max_value > 0, project_data.max_value, graduation_ratings.min_star), projects.flip_all, 0 ))',
            'holdSum' => 'SUM(IF(projects.Scam IS NOT NULL OR (projects.hold_all>0 AND '.$fieldHold1.' >= IF(project_data.max_value > 0, project_data.max_value, graduation_ratings.min_star)), projects.'.$fieldHold.', 0 ))',
//            'flipCount' => 'SUM(IF(projects.flip_all >= IF(project_data.max_value > 0, project_data.max_value, graduation_ratings.min_star), 1, 0 ))',
            'holdCount' => 'SUM(IF(projects.Scam IS NOT NULL OR (projects.hold_all>0 AND '.$fieldHold1.' >= IF(project_data.max_value > 0, project_data.max_value, graduation_ratings.min_star)), 1, 0 ))',
        ];

        $updatesFlip = ProjectData::find()
//            ->joinWith(['graduation'])
            ->join('INNER JOIN', 'graduation_ratings', 'project_data.graduation_id=graduation_ratings.id')
            ->join('INNER JOIN', 'projects', 'project_data.project_id=projects.id')
//            ->join('INNER JOIN', 'projects', 'project_data.project_id=projects.id')
            ->select($selectFlip)
            ->where(['=', 'project_data.expert_id', $expert_id])
//            ->andWhere('EXISTS ( SELECT 1 FROM hystorical_data where hystorical_data.project_id = project_data.project_id )' )
            ->groupBy('project_data.expert_id')
//            ->having('flipCount>=5 ')
//            ->having('ICO_Star>=5')
            ->asArray()
            ->all();

        /*if($expert_id == 1140) {
            die(print_r($updatesFlip));
        } else {
            return 0;
        }*/

        $updatesHold = ProjectData::find()
//            ->joinWith(['graduation'])
            ->join('LEFT JOIN', 'graduation_ratings', 'project_data.graduation_id=graduation_ratings.id')
            ->join('INNER JOIN', 'projects', 'project_data.project_id=projects.id')
            ->select($selectHold)
            ->where(['=', 'project_data.expert_id', $expert_id])
//            ->andWhere(['>=', 'projects.ICO_Star_Hold', 5])
            ->groupBy('project_data.expert_id')
//            ->having('holdCount>=5')
//            ->having('ICO_Star_Hold>=5')
            ->asArray()
            ->one();

//        print_r($updates);die();

        if(!empty($updatesFlip) || !empty($updatesHold)) {
            $model->flip = $updatesFlip['flipCount']==0 ? 0 : round($updatesFlip['flipSum'] / $updatesFlip['flipCount'],4);
            $model->hold = $updatesHold['holdCount']==0 ? 0 : round($updatesHold['holdSum'] / $updatesHold['holdCount'],4);
            $model->save();
        } else {
            $model->flip = 0;
            $model->hold = 0;
            $model->save();
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        \Yii::$app->queue->push(
            new RatingExpertJob(['expert_id' => $this->id])
        );
        /*\Yii::$app->queue->delay(3 * 60)->push(
            new RatingProjectJob()
        );*/
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}