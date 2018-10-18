<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Experts;

/**
 * ExpertsSearch represents the model behind the search form of `app\models\Experts`.
 */
class ExpertsSearch extends Experts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'old_description', 'description', 'spreadsheet', 'address', 'email', 'subscribe', 'comments'], 'safe'],
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
    public function search($params, $sort = null)
    {
        $query = Experts::find();

        // add conditions that should always apply here

        $arrDp = ['query' => $query];
        if(!empty($sort)) {
            $arrDp['sort'] = ['defaultOrder'=>$sort];
        }

        $dataProvider = new ActiveDataProvider($arrDp);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'old_description', $this->old_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'spreadsheet', $this->spreadsheet])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'subscribe', $this->subscribe])
            ->andFilterWhere(['like', 'comments', $this->comments]);

        return $dataProvider;
    }
}
