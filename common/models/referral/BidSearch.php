<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Bid;

/**
 * BidSearch represents the model behind the search form of `common\models\referral\Bid`.
 */
class BidSearch extends Bid
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bid_id', 'referral_id', 'bidder_agency_id'], 'integer'],
            [['sample_requirements', 'remarks', 'estimated_due', 'created_at', 'updated_at'], 'safe'],
            [['bid_amount'], 'number'],
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
        $query = Bid::find();

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
            'bid_id' => $this->bid_id,
            'referral_id' => $this->referral_id,
            'bidder_agency_id' => $this->bidder_agency_id,
            'bid_amount' => $this->bid_amount,
            'estimated_due' => $this->estimated_due,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'sample_requirements', $this->sample_requirements])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
