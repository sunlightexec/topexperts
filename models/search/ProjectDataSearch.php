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
    public $project_hold;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'expert_id', 'Report_Date', 'status', 'created_at', 'updated_at'], 'integer'],
            [['Score', 'searchProjectName', 'searchExpertName', 'project_hold'], 'safe'],
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
    public function search($params, $limit = null)
    {
        $query = ProjectData::find()
            ->joinWith(['project', 'expert']);

        if(!empty($limit)) $query = $query->limit($limit);

        // add conditions that should always apply here

        $dpParams = [
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['project_hold' => SORT_DESC]
            ]
        ];

        $dataProvider = new ActiveDataProvider($dpParams);

        $dataProvider->sort->attributes['project_hold'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['projects.hold_all' => SORT_ASC],
            'desc' => ['projects.hold_all' => SORT_DESC],
        ];

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
