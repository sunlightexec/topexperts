<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Projects;

/**
 * ProjectsSearch represents the model behind the search form of `app\models\Projects`.
 */
class ProjectsSearch extends Projects
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Category', 'Currency_HARD_CAP', 'Currency_ICO_Price', 'ICO_Star',
                'START_ICO', 'END_ICO', 'status', 'created_at', 'updated_at'], 'integer'],
            [['ICO_NAME', 'ICO_Website', 'ICO_Description', 'URL_Coinmarketcap', 'URL_ICODrops', 'Scam'], 'safe'],
            [['HARD_CAP', 'ICO_Price'], 'number'],
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
        $query = Projects::find();

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
            'Category' => $this->Category,
            'HARD_CAP' => $this->HARD_CAP,
            'Currency_HARD_CAP' => $this->Currency_HARD_CAP,
            'ICO_Price' => $this->ICO_Price,
            'Currency_ICO_Price' => $this->Currency_ICO_Price,
            'ICO_star' => $this->ICO_Star,
            'START_ICO' => $this->START_ICO,
            'END_ICO' => $this->END_ICO,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'ICO_NAME', $this->ICO_NAME])
            ->andFilterWhere(['like', 'ICO_Website', $this->ICO_Website])
            ->andFilterWhere(['like', 'ICO_Description', $this->ICO_Description])
            ->andFilterWhere(['like', 'URL_Coinmarketcap', $this->URL_Coinmarketcap])
            ->andFilterWhere(['like', 'URL_ICODrops', $this->URL_ICODrops])
            ->andFilterWhere(['like', 'Scam', $this->Scam]);

        return $dataProvider;
    }
}
