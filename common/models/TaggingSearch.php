<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Tagging;

/**
 * TaggingSearch represents the model behind the search form of `common\models\lab\Tagging`.
 */
class TaggingSearch extends Tagging
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tagging_id', 'user_id', 'analysis_id', 'tagging_status_id', 'cancelled_by', 'iso_accredited'], 'integer'],
            [['start_date', 'end_date', 'cancel_date', 'reason', 'disposed_date'], 'safe'],
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
        $query = Tagging::find();

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
            'tagging_id' => $this->tagging_id,
            'user_id' => $this->user_id,
            'analysis_id' => $this->analysis_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'tagging_status_id' => $this->tagging_status_id,
            'cancel_date' => $this->cancel_date,
            'cancelled_by' => $this->cancelled_by,
            'disposed_date' => $this->disposed_date,
            'iso_accredited' => $this->iso_accredited,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
