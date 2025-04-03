<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Analysis;

/**
 * AnalysisSearch represents the model behind the search form of `common\models\referral\Analysis`.
 */
class AnalysisSearch extends Analysis
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['analysis_id', 'analysis_type_id', 'agency_id', 'pstcanalysis_id', 'sample_id', 'testname_id', 'methodreference_id', 'cancelled', 'status', 'created_at', 'updated_at'], 'integer'],
            [['date_analysis'], 'safe'],
            [['analysis_fee'], 'number'],
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
        $query = Analysis::find();

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
            'analysis_type_id' => $this->analysis_type_id,
            'date_analysis' => $this->date_analysis,
            'agency_id' => $this->agency_id,
            'pstcanalysis_id' => $this->pstcanalysis_id,
            'sample_id' => $this->sample_id,
            'testname_id' => $this->testname_id,
            'methodreference_id' => $this->methodreference_id,
            'analysis_fee' => $this->analysis_fee,
            'cancelled' => $this->cancelled,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
