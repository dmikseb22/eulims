<?php

namespace common\models\lab;

use Yii;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Analysis;

/**
 * AnalysisSearch represents the model behind the search form of `common\models\lab\Analysis`.
 */
class AnalysisSearch extends Analysis
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['analysis_id', 'rstl_id', 'pstcanalysis_id', 'request_id', 'sample_id', 'quantity', 'test_id', 'cancelled', 'user_id', 'is_package'], 'integer'],
            [['date_analysis', 'sample_code', 'testname', 'method', 'references'], 'safe'],
            [['fee'], 'number'],
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
            'date_analysis' => $this->date_analysis,
            'rstl_id' => $this->rstl_id,
            'pstcanalysis_id' => $this->pstcanalysis_id,
            'request_id' => $this->request_id,
            'sample_id' => $this->sample_id,
            'quantity' => $this->quantity,
            'fee' => $this->fee,
            'test_id' => $this->test_id,
            'cancelled' => $this->cancelled,
            'user_id' => $this->user_id,
            'is_package' => $this->is_package,
        ]);

        $query->andFilterWhere(['like', 'sample_code', $this->sample_code])
            ->andFilterWhere(['like', 'testname', $this->testname])
            ->andFilterWhere(['like', 'method', $this->method])
            ->andFilterWhere(['like', 'references', $this->references]);

        return $dataProvider;
    }
}
