<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_data".
 *
 * @property int $id
 * @property int $project_id
 * @property int $expert_id
 * @property string $Score
 * @property int $Report_Date
 * @property double $flip
 * @property double $hold
 * @property int $graduation_id
 * @property int $max_value
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Experts $expert
 * @property Projects $project
 */
class ProjectData extends \yii\db\ActiveRecord
{
    public $searchProjectName;
    public $searchExpertName;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['max_value', 'project_id', 'expert_id', 'Report_Date', 'status', 'created_at', 'updated_at', 'graduation_id'], 'integer'],
            [['flip', 'hold'], 'double'],
            [['Score', 'searchProjectName', 'searchExpertName'], 'string', 'max' => 255],
            [['expert_id'], 'exist', 'skipOnError' => true, 'targetClass' => Experts::className(), 'targetAttribute' => ['expert_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['project_id' => 'id']],
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
            'project_id' => Yii::t('app/projects', 'Project ID'),
            'expert_id' => Yii::t('app/projects', 'Expert ID'),
            'Score' => Yii::t('app/projects', 'Score'),
            'Report_Date' => Yii::t('app/projects', 'Report  Date'),
            'graduation_id' => Yii::t('app/projects', 'Graduation'),
            'flip' => Yii::t('app/projects', 'Flip'),
            'hold' => Yii::t('app/projects', 'Hold'),
            'max_value' => Yii::t('app/projects', 'Min Star'),
            'status' => Yii::t('app/projects', 'Status'),
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
    public function getExpert()
    {
        return $this->hasOne(Experts::className(), ['id' => 'expert_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ProjectDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ProjectDataQuery(get_called_class());
    }
}
