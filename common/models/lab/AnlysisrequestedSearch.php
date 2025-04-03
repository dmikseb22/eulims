<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Analysisrequested;

/**
 * AnlysisrequestedSearch represents the model behind the search form of `common\models\lab\Analysisrequested`.
 */
class AnlysisrequestedSearch extends Analysisrequested
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['analysis_id', 'joborder_id'], 'integer'],
            [['sample_description', 'control_no', 'analysis', 'price', 'total', 'type', 'status'], 'safe'],
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
        $query = Analysisrequested::find();

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
            'analysis_id' => $this->analysis_id,
            'joborder_id' => $this->joborder_id,
        ]);

        $query->andFilterWhere(['like', 'sample_description', $this->sample_description])
            ->andFilterWhere(['like', 'control_no', $this->control_no])
            ->andFilterWhere(['like', 'analysis', $this->analysis])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
