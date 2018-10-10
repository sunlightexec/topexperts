<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\helpers\Exceptions;

/**
 * ExceptionsSearch represents the model behind the search form of `app\models\helpers\Exceptions`.
 */
class ExceptionsSearch extends Exceptions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['site', 'msg_true', 'msg_fall', 'msg_fall2'], 'safe'],
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
        $query = Exceptions::find();

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
            'project_id' => $this->project_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'msg_true', $this->msg_true])
            ->andFilterWhere(['like', 'msg_fall', $this->msg_fall])
            ->andFilterWhere(['like', 'msg_fall2', $this->msg_fall2]);

        return $dataProvider;
    }
}
