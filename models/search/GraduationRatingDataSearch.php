<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GraduationRatingData;

/**
 * GraduationRatingDataSearch represents the model behind the search form of `app\models\GraduationRatingData`.
 */
class GraduationRatingDataSearch extends GraduationRatingData
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'graduation_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['score'], 'safe'],
            [['value'], 'number'],
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
        $query = GraduationRatingData::find();

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
            'graduation_id' => $this->graduation_id,
            'value' => $this->value,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'score', $this->score]);

        return $dataProvider;
    }
}
