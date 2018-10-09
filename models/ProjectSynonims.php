<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_synonims".
 *
 * @property int $id
 * @property string $project_name
 * @property string $project_synonim
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class ProjectSynonims extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_synonims';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_name'], 'required'],
            [['project_synonim'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['project_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/project_synonims', 'ID'),
            'project_name' => Yii::t('app/project_synonims', 'Project Name'),
            'project_synonim' => Yii::t('app/project_synonims', 'Project Synonim'),
            'status' => Yii::t('app/project_synonims', 'Status'),
            'created_at' => Yii::t('app/project_synonims', 'Created At'),
            'updated_at' => Yii::t('app/project_synonims', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ProjectSynonimsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ProjectSynonimsQuery(get_called_class());
    }
}
