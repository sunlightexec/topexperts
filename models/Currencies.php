<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property string $name
 * @property double $value
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Projects[] $projects
 * @property Projects[] $projects0
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['value'], 'number'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app/categories', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'status' => Yii::t('app/categories', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsHardCap()
    {
        return $this->hasMany(Projects::className(), ['Currency_HARD_CAP' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsIcoPrice()
    {
        return $this->hasMany(Projects::className(), ['Currency_ICO_Price' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\CurrenciesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CurrenciesQuery(get_called_class());
    }
}
