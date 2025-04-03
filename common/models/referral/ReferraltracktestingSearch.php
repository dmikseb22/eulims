<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Referraltracktesting;

/**
 * ReferraltracktestingSearch represents the model behind the search form of `common\models\referral\Referraltracktesting`.
 */
class ReferraltracktestingSearch extends Referraltracktesting
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referraltracktesting_id', 'referral_id', 'testing_agency_id', 'receiving_agency_id', 'courier_id'], 'integer'],
            [['date_received_courier', 'analysis_started', 'analysis_completed', 'cal_specimen_send_date', 'date_created'], 'safe'],
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
        $query = Referraltracktesting::find();

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
            'referraltracktesting_id' => $this->referraltracktesting_id,
            'referral_id' => $this->referral_id,
            'testing_agency_id' => $this->testing_agency_id,
            'receiving_agency_id' => $this->receiving_agency_id,
            'date_received_courier' => $this->date_received_courier,
            'analysis_started' => $this->analysis_started,
            'analysis_completed' => $this->analysis_completed,
            'cal_specimen_send_date' => $this->cal_specimen_send_date,
            'courier_id' => $this->courier_id,
            'date_created' => $this->date_created,
        ]);

        return $dataProvider;
    }
}
