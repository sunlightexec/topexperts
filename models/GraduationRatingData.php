<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "graduation_rating_data".
 *
 * @property int $id
 * @property int $graduation_id
 * @property string $score
 * @property double $value
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GraduationRatings $graduation
 */
class GraduationRatingData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'graduation_rating_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['graduation_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'number'],
            [['score'], 'string', 'max' => 255],
            [['graduation_id'], 'exist', 'skipOnError' => true, 'targetClass' => GraduationRatings::className(), 'targetAttribute' => ['graduation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'graduation_id' => Yii::t('app/graduation-ratings', 'Graduation'),
            'score' => Yii::t('app/graduation-ratings', 'Score'),
            'value' => Yii::t('app/graduation-ratings', 'Value'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGraduation()
    {
        return $this->hasOne(GraduationRatings::className(), ['id' => 'graduation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectDatas()
    {
        return $this->hasMany(\app\models\helpers\ProjectData::className(), ['graduation_id' => 'graduation_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\GraduationRatingDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\GraduationRatingDataQuery(get_called_class());
    }
}
