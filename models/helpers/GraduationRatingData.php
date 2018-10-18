<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.10.2018
 * Time: 16:13
 */

namespace app\models\helpers;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use app\components\jobs\RatingExpertJob;
use app\components\jobs\RatingProjectJob;

class GraduationRatingData extends \app\models\GraduationRatingData
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

    public function beforeSave($insert)
    {
        if($this->isNewRecord) {
            $min = GraduationRatings::getMinValue($this->graduation_id);
            $max = GraduationRatings::getMaxValue($this->graduation_id);

            if( !empty($max) && $this->value > $max->value ) {

                foreach($max->getProjectDatas()->all() as $item) {
                    $item->Score = $this->score;
                    $item->save();
                }
            } elseif(!empty($min) && $this->value < $min->value) {
                foreach($min->getProjectDatas()->all() as $item) {
                    $item->Score = $this->score;
                    $item->save();
                }
            } else {
                \Yii::warning("Create unrecognized data:\nGraduation.Id=" .
                    $this->getGraduation()->one()->id .
                    "\n Data: {$this->score}\n"
                );
            }
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        \Yii::$app->queue->push(
            new RatingExpertJob()
        );
        \Yii::$app->queue->delay(3 * 60)->push(
            new RatingProjectJob()
        );
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public static function getValues($graduation_id)
    {
        $arCats = self::find()->where(['=', 'graduation_id', $graduation_id])->all();
        return ArrayHelper::map($arCats, 'score', 'score');
    }

    public static function applyRating($oProjectData)
    {
        $score = explode('/', $oProjectData->Score);
        if(count($score) == 1) {
            $flip = $hold = $score[0];
        } else {
            $flip = $score[0];
            $hold = $score[1];
        }

        $modelFlip = GraduationRatingData::find()
            ->joinWith(['graduation'])
            ->where(['like', 'graduation_ratings.allowed', ',' . $oProjectData->expert->name . ','])
            ->andFilterWhere(['score' => strtoupper($flip)])
            ->one();
        if(!empty($modelFlip)) {
            $oProjectData->flip = $modelFlip->value;
            $oProjectData->graduation_id = $modelFlip->getGraduation()->one()->id;
            $oProjectData->save();
        } else {
            $filter = [];
            $filter['type'] = 2;
            if(strpos($flip, '%') !== false) {
                $filter['max_value'] = 100;
            }

            $modelFlip = GraduationRatings::find()
                ->where(['like', 'allowed', ',' . $oProjectData->expert->name . ','])
                ->andFilterWhere($filter)
                ->one();

            if($modelFlip->type == 2) {
                $oProjectData->flip = ((double)str_replace(['%',','], ['','.'], $flip) * 10 / $modelFlip->max_value);
                $oProjectData->graduation_id = $modelFlip->id;
                $oProjectData->save();
            }
        }
        $modelHold = GraduationRatingData::find()
            ->joinWith(['graduation'])
            ->where(['like', 'graduation_ratings.allowed', ',' . $oProjectData->expert->name . ','])
            ->where(['=', 'score', strtoupper($hold)])
            ->one();
        if(!empty($modelHold)) {
            $oProjectData->hold = $modelHold->value;
            if(empty($modelFlip))
                $oProjectData->graduation_id = $modelHold->getGraduation()->one()->id;
            $oProjectData->save();
        } else {
            $filter = [];
            $filter['type'] = 2;
            if(strpos($hold, '%') !== false) {
                $filter['max_value'] = 100;
            }
            $modelHold = GraduationRatings::find()
                ->where(['like', 'allowed', ',' . $oProjectData->expert->name . ','])
                ->andFilterWhere($filter)
                ->one();

            if(!empty($modelHold) && $modelHold->type == 2) {
                $oProjectData->hold = ((double)str_replace(['%',','], ['','.'], $flip) * 10 / $modelHold->max_value);
                $oProjectData->graduation_id = $modelHold->id;
                $oProjectData->save();
            }
        }
    }

    public static function applyRatingWithId(ProjectData $oProjectData)
    {
        $score = explode('/', $oProjectData->Score);
        if(count($score) == 1) {
            $flip = $hold = $score[0];
        } else {
            $flip = $score[0];
            $hold = $score[1];
        }

        $modelFlip = GraduationRatingData::find()
            ->joinWith(['graduation'])
            ->where(['=', 'graduation_ratings.id', $oProjectData->graduation_id])
            ->andFilterWhere(['score' => strtoupper($flip)])
            ->one();
//        die(print_r($modelFlip->attributes));
        if(!empty($modelFlip)) {
            $oProjectData->flip = $modelFlip->value;
            $oProjectData->save();
        } else {
            $filter = [];
            $filter['type'] = 2;
            if(strpos($flip, '%') !== false) {
                $filter['max_value'] = 100;
            }

            $modelFlip = GraduationRatings::find()
                ->where(['=', 'graduation_ratings.id', $oProjectData->graduation_id])
                ->andFilterWhere($filter)
                ->one();

            if($modelFlip->type == 2) {
                $oProjectData->flip = ((double)str_replace(['%',','], ['','.'], $flip) * 10 / $modelFlip->max_value);
                $oProjectData->save();
            }
        }
        $modelHold = GraduationRatingData::find()
            ->joinWith(['graduation'])
            ->where(['=', 'graduation_ratings.id', $oProjectData->graduation_id])
            ->andFilterWhere(['score'=> strtoupper($hold)])
            ->one();
        if(!empty($modelHold)) {
            $oProjectData->hold = $modelHold->value;
            $oProjectData->save();
        } else {
            $filter = [];
            $filter['type'] = 2;
            if(strpos($hold, '%') !== false) {
                $filter['max_value'] = 100;
            }
            $modelHold = GraduationRatings::find()
                ->where(['=', 'graduation_ratings.id', $oProjectData->graduation_id])
                ->andFilterWhere($filter)
                ->one();

            if($modelHold->type == 2) {
                $oProjectData->hold = ((double)str_replace(['%',','], ['','.'], $flip) * 10 / $modelHold->max_value);
                $oProjectData->save();
            }
        }
    }
}