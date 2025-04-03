<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Referraltrackreceiving;

/**
 * ReferraltrackreceivingSearch represents the model behind the search form of `common\models\referral\Referraltrackreceiving`.
 */
class ReferraltrackreceivingSearch extends Referraltrackreceiving
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referraltrackreceiving_id', 'referral_id', 'receiving_agency_id', 'testing_agency_id', 'courier_id'], 'integer'],
            [['sample_received_date', 'shipping_date', 'cal_specimen_received_date', 'date_created'], 'safe'],
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
        $query = Referraltrackreceiving::find();

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
            'referraltrackreceiving_id' => $this->referraltrackreceiving_id,
            'referral_id' => $this->referral_id,
            'receiving_agency_id' => $this->receiving_agency_id,
            'testing_agency_id' => $this->testing_agency_id,
            'sample_received_date' => $this->sample_received_date,
            'courier_id' => $this->courier_id,
            'shipping_date' => $this->shipping_date,
            'cal_specimen_received_date' => $this->cal_specimen_received_date,
            'date_created' => $this->date_created,
        ]);

        return $dataProvider;
    }
}
