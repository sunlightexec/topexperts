<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hystorical_data".
 *
 * @property int $id
 * @property int $currency_id
 * @property int $circulating_supply
 * @property int $total_supply
 * @property int $max_supply
 * @property int $date_added
 * @property double $price
 * @property double $volume_24h
 * @property double $market_cap
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Currencies $currency
 */
class HystoricalData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hystorical_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currency_id', 'date_added', 'status', 'created_at', 'updated_at'], 'integer'],
            [['circulating_supply', 'total_supply', 'max_supply', 'updated_at'], 'double'],
            [['price', 'volume_24h', 'market_cap'], 'number'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'currency_id' => Yii::t('app/hystirical-data', 'Currency ID'),
            'circulating_supply' => Yii::t('app/hystirical-data', 'Circulating Supply'),
            'total_supply' => Yii::t('app/hystirical-data', 'Total Supply'),
            'max_supply' => Yii::t('app/hystirical-data', 'Max Supply'),
            'date_added' => Yii::t('app/hystirical-data', 'Date Added'),
            'price' => Yii::t('app/hystirical-data', 'Price'),
            'volume_24h' => Yii::t('app/hystirical-data', 'Volume'),
            'market_cap' => Yii::t('app/hystirical-data', 'Market Cap'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'currency_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\HystoricalDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\HystoricalDataQuery(get_called_class());
    }
}
