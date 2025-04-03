<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Sample;

/**
 * SampleSearch represents the model behind the search form about `common\models\lab\Sample`.
 */
class SampleSearch extends Sample
{

    public $request_ref_num;
    public $type;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sample_id', 'rstl_id', 'pstcsample_id', 'sample_month', 'sample_year', 'active'], 'integer'],
            [['sample_code', 'samplename', 'description', 'sampling_date', 'request_id', 'sampletype_id', 'remarks'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Sample::find();

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

        $query->joinWith(['request']);

        // grid filtering conditions
        $query->andFilterWhere([
            'sample_id' => $this->sample_id,
            'rstl_id' => $this->rstl_id,
            'pstcsample_id' => $this->pstcsample_id,
            'sampletype_id' => $this->sampletype_id,
            'sampling_date' => $this->sampling_date,
            //'request_id' => $this->request_id,
            'sample_month' => $this->sample_month,
            'sample_year' => $this->sample_year,
            'active' => $this->active,
        ]);
        $query->orderby('request_id DESC');

        $query->andFilterWhere(['like', 'sample_code', $this->sample_code])
            //->andFilterWhere(['like', 'tbl_sampletype.sample_type', $this->sample_type_id])
            ->andFilterWhere(['like', 'tbl_request.request_ref_num', $this->request_id])
            ->andFilterWhere(['like', 'samplename', $this->samplename])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
