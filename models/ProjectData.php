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
            [['project_id', 'expert_id', 'Report_Date', 'status', 'created_at', 'updated_at'], 'integer'],
            [['Score', 'searchProjectName', 'searchExpertName'], 'string', 'max' => 255],
            [['expert_id'], 'exist', 'skipOnError' => true, 'targetClass' => Experts::className(), 'targetAttribute' => ['expert_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/projects', 'ID'),
            'project_id' => Yii::t('app/projects', 'Project ID'),
            'expert_id' => Yii::t('app/projects', 'Expert ID'),
            'Score' => Yii::t('app/projects', 'Score'),
            'Report_Date' => Yii::t('app/projects', 'Report  Date'),
            'status' => Yii::t('app/projects', 'Status'),
            'created_at' => Yii::t('app/projects', 'Created At'),
            'updated_at' => Yii::t('app/projects', 'Updated At'),
        ];
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
