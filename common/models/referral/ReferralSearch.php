<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Referral;

/**
 * ReferralSearch represents the model behind the search form about `common\models\referral\Referral`.
 */
class ReferralSearch extends Referral
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['referral_id', 'receiving_agency_id', 'testing_agency_id', 'lab_id', 'customer_id', 'payment_type_id', 'modeofrelease_id', 'purpose_id', 'discount_id', 'received_by'], 'integer'],
            [['referral_code', 'referral_date_time', 'sample_received_date', 'report_due', 'conforme', 'bid', 'cancelled', 'create_time', 'update_time'], 'safe'],
            [['discount_amt', 'total_fee'], 'number'],
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
        $query = Referral::find();

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
            'referral_id' => $this->referral_id,
            'referral_date_time' => $this->referral_date_time,
            'receiving_agency_id' => $this->receiving_agency_id,
            'testing_agency_id' => $this->testing_agency_id,
            'lab_id' => $this->lab_id,
            'sample_received_date' => $this->sample_received_date,
            'customer_id' => $this->customer_id,
            'payment_type_id' => $this->payment_type_id,
            'modeofrelease_id' => $this->modeofrelease_id,
            'purpose_id' => $this->purpose_id,
            'discount_id' => $this->discount_id,
            'discount_amt' => $this->discount_amt,
            'total_fee' => $this->total_fee,
            'report_due' => $this->report_due,
            'received_by' => $this->received_by,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'referral_code', $this->referral_code])
            ->andFilterWhere(['like', 'conforme', $this->conforme])
            ->andFilterWhere(['like', 'bid', $this->bid])
            ->andFilterWhere(['like', 'cancelled', $this->cancelled]);

        return $dataProvider;
    }
}
