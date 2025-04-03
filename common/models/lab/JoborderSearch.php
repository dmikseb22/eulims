<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Joborder;

/**
 * JoborderSearch represents the model behind the search form of `common\models\lab\Joborder`.
 */
class JoborderSearch extends Joborder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['joborder_id', 'customer_id'], 'integer'],
            [['joborder_date', 'sampling_date', 'lsono', 'sample_received'], 'safe'],
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
        $query = Joborder::find();

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
            'joborder_id' => $this->joborder_id,
            'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like', 'joborder_date', $this->joborder_date])
            ->andFilterWhere(['like', 'sampling_date', $this->sampling_date])
            ->andFilterWhere(['like', 'lsono', $this->lsono])
            ->andFilterWhere(['like', 'sample_received', $this->sample_received]);

        return $dataProvider;
    }
} 