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
    public $project_flip;
    public $is_star;
    public $is_coined;
    public $project_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_coined', 'id', 'project_id', 'expert_id', 'Report_Date', 'status', 'created_at', 'updated_at'], 'integer'],
            [['project_name','Score', 'searchProjectName', 'searchExpertName', 'project_hold', 'is_star'], 'safe'],
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

        $dataProvider->sort->attributes['project_flip'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['projects.flip_all' => SORT_ASC],
            'desc' => ['projects.flip_all' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['is_star'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
//            'asc' => [ new \yii\db\Expression(' FIELD (flip, IF(flip >=8,1,0))') => SORT_ASC],
            'asc' => [ ' IF(project_data.flip >=8,1,0)' => SORT_ASC],
            'desc' => [ ' IF(project_data.flip >=8,1,0)' => SORT_DESC],
//            'desc' => ['projects.ICO_Star' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['project_name'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
//            'asc' => [ new \yii\db\Expression(' FIELD (flip, IF(flip >=8,1,0))') => SORT_ASC],
            'asc' => ['projects.ICO_Name' => SORT_ASC],
            'desc' => ['projects.ICO_Name' => SORT_DESC],
//            'desc' => ['projects.ICO_Star' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(isset($this->is_coined)) {
            if($this->is_coined == 1) {
                $condition = 'EXISTS (SELECT 1 FROM hystorical_data WHERE hystorical_data.project_id = project_data.project_id)';
                $query->where($condition);
            } elseif($this->is_coined == 2) {
                $condition = 'NOT EXISTS (SELECT 1 FROM hystorical_data WHERE hystorical_data.project_id = project_data.project_id)';
                $query->where($condition);
            }
        }

        if(isset($this->is_star)) {
            if($this->is_star == 1) {
                $condition = 'project_data.flip >=8 OR project_data.hold >= 8';
                $query->andWhere($condition);
            } elseif($this->is_star == 2) {
                $condition = 'project_data.flip <8 AND project_data.hold < 8';
                $query->andWhere($condition);
            }
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
