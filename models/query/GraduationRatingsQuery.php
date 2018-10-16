<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\GraduationRatings]].
 *
 * @see \app\models\GraduationRatings
 */
class GraduationRatingsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\GraduationRatings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\GraduationRatings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
