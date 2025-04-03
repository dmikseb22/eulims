<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Sample;

/**
 * SampleSearch represents the model behind the search form of `common\models\referral\Sample`.
 */
class SampleSearch extends Sample
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sample_id', 'referral_id', 'receiving_agency_id', 'pstcsample_id', 'package_id', 'sample_type_id', 'sample_month', 'sample_year', 'active'], 'integer'],
            [['package_fee'], 'number'],
            [['sample_code', 'samplename', 'description', 'sampling_date', 'remarks'], 'safe'],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'sample_id' => $this->sample_id,
            'referral_id' => $this->referral_id,
            'receiving_agency_id' => $this->receiving_agency_id,
            'pstcsample_id' => $this->pstcsample_id,
            'package_id' => $this->package_id,
            'package_fee' => $this->package_fee,
            'sample_type_id' => $this->sample_type_id,
            'sampling_date' => $this->sampling_date,
            'sample_month' => $this->sample_month,
            'sample_year' => $this->sample_year,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'sample_code', $this->sample_code])
            ->andFilterWhere(['like', 'samplename', $this->samplename])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
