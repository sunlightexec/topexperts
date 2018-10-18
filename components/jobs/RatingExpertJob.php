<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 18.10.2018
 * Time: 18:36
 */

namespace app\components\jobs;
use yii\base\BaseObject;
use app\models\helpers\Experts;

class RatingExpertJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        $arExperts = Experts::find()->all();
        $row = 1;
        foreach ($arExperts as $oExpert) {
            Experts::setRatings($oExpert->id);
        }
    }
}