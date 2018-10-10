<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exceptions".
 *
 * @property int $id
 * @property int $project_id
 * @property string $site
 * @property string $msg_true
 * @property string $msg_fall
 * @property string $msg_fall2
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Experts $expert
 */
class Exceptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exceptions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['site', 'msg_true', 'msg_fall', 'msg_fall2'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\helpers\Projects::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app/exceptions', 'Project'),
            'site' => Yii::t('app/exceptions', 'Site'),
            'msg_true' => Yii::t('app/exceptions', 'Msg True'),
            'msg_fall' => Yii::t('app/exceptions', 'Msg Fall'),
            'msg_fall2' => Yii::t('app/exceptions', 'Msg Fall2'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(\app\models\helpers\Projects::className(), ['id' => 'project_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ExceptionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ExceptionsQuery(get_called_class());
    }
}
