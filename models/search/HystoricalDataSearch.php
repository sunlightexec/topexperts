<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HystoricalData;

/**
 * HystoricalDataSearch represents the model behind the search form of `app\models\HystoricalData`.
 */
class HystoricalDataSearch extends HystoricalData
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'currency_id', 'circulating_supply', 'total_supply', 'max_supply', 'date_added', 'status', 'created_at', 'updated_at'], 'integer'],
            [['price', 'volume_24h', 'market_cap'], 'number'],
            [['searchName', 'searchURL', 'searchCurrency'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = HystoricalData::find()
            ->joinWith(['project', 'currency']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'currency_id' => $this->currency_id,
            'circulating_supply' => $this->circulating_supply,
            'total_supply' => $this->total_supply,
            'max_supply' => $this->max_supply,
            'date_added' => $this->date_added,
            'price' => $this->price,
            'volume_24h' => $this->volume_24h,
            'market_cap' => $this->market_cap,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'projects.ICO_NAME', $this->searchName])
            ->andFilterWhere(['like', 'projects.ICO_Website', $this->searchURL])
            ->andFilterWhere(['like', 'currencies.name', $this->searchCurrency]);

        return $dataProvider;
    }
}
