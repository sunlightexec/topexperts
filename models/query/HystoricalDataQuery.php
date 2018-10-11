<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\HystoricalData]].
 *
 * @see \app\models\HystoricalData
 */
class HystoricalDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\HystoricalData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\HystoricalData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
