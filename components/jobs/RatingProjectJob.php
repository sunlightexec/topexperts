<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 18.10.2018
 * Time: 18:36
 */

namespace app\components\jobs;
use yii\base\BaseObject;
use app\models\helpers\Projects;

class RatingProjectJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        $arProjects = Projects::find()->all();
        foreach ($arProjects as $oProject) {
            Projects::setRatings($oProject->id);
        }
    }
}