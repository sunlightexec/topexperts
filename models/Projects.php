<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string $ICO_NAME
 * @property string $ICO_Website
 * @property string $ICO_Description
 * @property string $URL_Coinmarketcap
 * @property string $URL_ICODrops
 * @property int $Category
 * @property double $HARD_CAP
 * @property int $Currency_HARD_CAP
 * @property double $ICO_Price
 * @property int $Currency_ICO_Price
 * @property int $START_ICO
 * @property int $END_ICO
 * @property string $Scam
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProjectData[] $projectDatas
 * @property Categories $category
 * @property Currencies $currencyHARDCAP
 * @property Currencies $currencyICOPrice
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICO_NAME'], 'required'],
            [['ICO_Description'], 'string'],
            [['Category', 'Currency_HARD_CAP', 'Currency_ICO_Price', 'status', 'created_at', 'updated_at'], 'integer'],
            [['HARD_CAP', 'ICO_Price'], 'number'],
            [['ICO_NAME', 'ICO_Website', 'URL_Coinmarketcap', 'URL_ICODrops', 'Scam'], 'string', 'max' => 255],
            [['ICO_NAME'], 'unique'],
            [['Category'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['Category' => 'id']],
            [['Currency_HARD_CAP'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['Currency_HARD_CAP' => 'id']],
            [['Currency_ICO_Price'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['Currency_ICO_Price' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ICO_NAME' => Yii::t('app/projects', 'Ico  Name'),
            'ICO_Website' => Yii::t('app/projects', 'Ico  Website'),
            'ICO_Description' => Yii::t('app/projects', 'Ico  Description'),
            'URL_Coinmarketcap' => Yii::t('app/projects', 'Url  Coinmarketcap'),
            'URL_ICODrops' => Yii::t('app/projects', 'Url  Icodrops'),
            'Category' => Yii::t('app/projects', 'Category'),
            'HARD_CAP' => Yii::t('app/projects', 'Hard  Cap'),
            'Currency_HARD_CAP' => Yii::t('app/projects', 'Currency  Hard  Cap'),
            'ICO_Price' => Yii::t('app/projects', 'Ico  Price'),
            'Currency_ICO_Price' => Yii::t('app/projects', 'Currency  Ico  Price'),
            'START_ICO' => Yii::t('app/projects', 'Start  Ico'),
            'END_ICO' => Yii::t('app/projects', 'End  Ico'),
            'Scam' => Yii::t('app/projects', 'Scam'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectDatas()
    {
        return $this->hasMany(ProjectData::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'Category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyHARDCAP()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'Currency_HARD_CAP']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyICOPrice()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'Currency_ICO_Price']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ProjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ProjectsQuery(get_called_class());
    }
}
