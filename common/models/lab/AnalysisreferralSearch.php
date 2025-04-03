<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Analysis;

/**
 * AnalysisreferralSearch represents the model behind the search form of `common\models\lab\Analysis`.
 */
class AnalysisreferralSearch extends Analysis
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['analysis_id', 'rstl_id', 'pstcanalysis_id', 'request_id', 'sample_id', 'quantity', 'test_id', 'testcategory_id', 'sample_type_id', 'cancelled', 'user_id', 'is_package', 'type_fee_id', 'old_sample_id', 'analysis_old_id', 'oldColumn_taggingId', 'oldColumn_package_count', 'oldColumn_deleted', 'methodreference_id', 'testname_id', 'old_request_id', 'local_analysis_id', 'local_sample_id', 'local_request_id'], 'integer'],
            [['date_analysis', 'sample_code', 'testname', 'method', 'references', 'oldColumn_result', 'oldColumn_requestId'], 'safe'],
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
            'testcategory_id' => $this->testcategory_id,
            'sample_type_id' => $this->sample_type_id,
            'cancelled' => $this->cancelled,
            'user_id' => $this->user_id,
            'is_package' => $this->is_package,
            'type_fee_id' => $this->type_fee_id,
            'old_sample_id' => $this->old_sample_id,
            'analysis_old_id' => $this->analysis_old_id,
            'oldColumn_taggingId' => $this->oldColumn_taggingId,
            'oldColumn_package_count' => $this->oldColumn_package_count,
            'oldColumn_deleted' => $this->oldColumn_deleted,
            'methodreference_id' => $this->methodreference_id,
            'testname_id' => $this->testname_id,
            'old_request_id' => $this->old_request_id,
            'local_analysis_id' => $this->local_analysis_id,
            'local_sample_id' => $this->local_sample_id,
            'local_request_id' => $this->local_request_id,
        ]);

        $query->andFilterWhere(['like', 'sample_code', $this->sample_code])
            ->andFilterWhere(['like', 'testname', $this->testname])
            ->andFilterWhere(['like', 'method', $this->method])
            ->andFilterWhere(['like', 'references', $this->references])
            ->andFilterWhere(['like', 'oldColumn_result', $this->oldColumn_result])
            ->andFilterWhere(['like', 'oldColumn_requestId', $this->oldColumn_requestId]);

        return $dataProvider;
    }
}
