<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 10.10.2018
 * Time: 19:39
 */

namespace app\models\helpers;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use app\models\helpers\ProjectSynonims;
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

    public static function getList()
    {
        $arCats = self::find()->all();
        return ArrayHelper::map($arCats, 'id', 'ICO_NAME');
    }

    public static function getProjectByAttr($name, $slug, $url = null) {
        $url = str_replace(['http://', 'https://'], '', $url);
        $name = strtoupper($name);
        $slug = strtoupper($slug);
//        $projectModel = self::find()->where(['like', 'UPPER(ICO_NAME)', $name, false])->one();
        $projectModel = self::find()->where(['=', 'UPPER(ICO_NAME)', $name])->one();

        if(empty($projectModel)) {
//            $projectModel = self::find()->where(['like', 'ICO_NAME', $slug, fa;se])->one();
            $projectModel = self::find()->where(['=', 'UPPER(ICO_NAME)', $slug])->one();
        }

        if(empty($projectModel)) {

//            $synonimModel = ProjectSynonims::find()->where(['like', 'project_synonim', $name, false])->one();
            $synonimModel = ProjectSynonims::find()->where(['=', 'UPPER(project_synonim)', $name])->one();
            if(empty($synonimModel))
//                $synonimModel = ProjectSynonims::find()->where(['like', 'project_synonim', $slug, false])->one();
                $synonimModel = ProjectSynonims::find()->where(['=', 'UPPER(project_synonim)', $slug])->one();
            /*if(empty($synonimModel))
                $synonimModel = ProjectSynonims::find()->where(['like', 'project_synonim', $slug.'%', false])->one();*/

            if(!empty($synonimModel))
                $projectModel = self::find()->where(['=', 'ICO_NAME', $synonimModel->project_name])->one();
        }
        /*if(empty($projectModel)) {
            $synonimModel = ProjectSynonims::find()->where(['like', 'project_synonim', $slug.'%', false])->one();
            if(!empty($synonimModel))
                $projectModel = self::find()->where(['=', 'ICO_NAME', $synonimModel->project_name])->one();
        }
        if(empty($projectModel)) {
            $synonimModel = ProjectSynonims::find()->where(['like', 'project_synonim', $slug.'%', false])->one();
            if(!empty($synonimModel))
                $projectModel = self::find()->where(['=', 'ICO_NAME', $synonimModel->project_name])->one();
        }*/
        if(empty($projectModel) && !empty($url)) {
            $projectModel = self::find()->where(['like', 'ICO_Website', $url])->one();
            if(empty($projectModel)) {
                $synonimModel = ProjectSynonims::find()->where(['like', 'project_synonim', $url])->one();
                if(!empty($synonimModel))
                    $projectModel = self::find()->where(['=', 'ICO_NAME', $synonimModel->project_name])->one();
            }
        }

        return $projectModel;
    }

    public static function setAllStar()
    {

    }

    public static function setStar($id)
    {
        $oProject = Projects::find()->where(['=', 'id', $id])->one();
        $starFlip = $oProject->getStarProjectFlip()->asArray()->one();
        $starHold = $oProject->getStarProjectHold()->asArray()->one();

        $oProject->ICO_Star = empty($starFlip) ? 0 : $starFlip['cnt'];
        $oProject->ICO_Star_Hold = empty($starHold) ? 0 : $starHold['cnt'];
        $oProject->save();
    }

    public static function setRatings($project_id)
    {
        $modelProject = self::find()->where(['=', 'id', $project_id])->one();
        $price = $modelProject->ICO_Price;
        $currPrice = HystoricalData::getHoldPrice($modelProject->id);
        if($modelProject->currencyICOPrice && $modelProject->currencyICOPrice->name != 'USD') {
            $price = $currPrice;
        }
        if($price > 0 && $currPrice > 0) {
            $data = [
                'flip_all' => HystoricalData::getMaxPrice($modelProject->id) / $price,
                'flip_12' => HystoricalData::getMaxPrice($modelProject->id, 'year') / $price,
                'flip_3' => HystoricalData::getMaxPrice($modelProject->id, 'quarter') / $price,
                'hold_all' => HystoricalData::getHoldPrice($modelProject->id) / $price,
                'hold_12' => HystoricalData::getHoldPrice($modelProject->id, 'year') / $price,
                'hold_3' => HystoricalData::getHoldPrice($modelProject->id, 'quarter') / $price,
            ];


        } else {
            $data = [
                'flip_all' => 0,
                'flip_12' => 0,
                'flip_3' => 0,
                'hold_all' => 0,
                'hold_12' => 0,
                'hold_3' => 0,
            ];
        }
        foreach ($data as $key => $value) {
            $modelProject->$key = $value;
        }
        if(!$modelProject->save()) {
            print_r([$modelProject->errors, $modelProject->name]);
        }

    }
}