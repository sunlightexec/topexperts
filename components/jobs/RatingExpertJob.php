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
    public $expert_id = null;

    public function execute($queue)
    {
        if(!empty($this->expert_id)) {
            $arExperts = Experts::find()->where(['=', 'id', $this->expert_id])->all();
        } else {
            $arExperts = Experts::find()->all();
        }

        foreach ($arExperts as $oExpert) {
            Experts::setRatings($oExpert->id);
        }
    }
}