<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "graduation_ratings".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $min_star
 * @property int $divider
 * @property int $max_value
 * @property text $allowed
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GraduationRatingData[] $graduationRatingDatas
 * @property ProjectData[] $projectDatas
 */
class GraduationRatings extends \yii\db\ActiveRecord
{
    private static $ListTypes = [
        1 => 'Selector',
        2 => 'Input Value'
    ];

    public $arrAllowed;

    public static function getListType()
    {
        return self::$ListTypes;
    }

    public static function getNameType($type)
    {
        return self::$ListTypes[$type];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'graduation_ratings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'status', 'created_at', 'updated_at', 'min_star', 'divider', 'max_value'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['allowed'], 'string'],
            [['arrAllowed', 'allowed'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app/graduation-ratings', 'Name'),
            'type' => Yii::t('app/graduation-ratings', 'Type'),
            'min_star' => Yii::t('app/graduation-ratings', 'Min Star'),
            'max_value' => Yii::t('app/graduation-ratings', 'Max Value'),
            'divider' => Yii::t('app/graduation-ratings', 'Divider'),
            'allowed' => Yii::t('app/graduation-ratings', 'Allowed'),
            'arrAllowed' => Yii::t('app/graduation-ratings', 'Allowed'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGraduationRatingDatas()
    {
        return $this->hasMany(GraduationRatingData::className(), ['graduation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectDatas()
    {
        return $this->hasMany(ProjectData::className(), ['graduation_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\GraduationRatingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\GraduationRatingsQuery(get_called_class());
    }
}
