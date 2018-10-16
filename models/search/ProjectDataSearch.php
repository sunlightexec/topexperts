<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProjectData;

/**
 * ProjectDataSearch represents the model behind the search form of `app\models\ProjectData`.
 */
class ProjectDataSearch extends ProjectData
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'expert_id', 'Report_Date', 'status', 'created_at', 'updated_at'], 'integer'],
            [['Score', 'searchProjectName', 'searchExpertName'], 'safe'],
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
        $query = ProjectData::find()->joinWith(['project', 'expert']);

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
            'expert_id' => $this->expert_id,
            'Report_Date' => $this->Report_Date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'Score', $this->Score])
            ->andFilterWhere(['like', 'projects.ICO_Name', $this->searchProjectName])
            ->andFilterWhere(['like', 'experts.name', $this->searchExpertName]);

        return $dataProvider;
    }
}
