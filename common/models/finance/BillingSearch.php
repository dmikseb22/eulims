<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\Billing;

/**
 * BillingSearch represents the model behind the search form about `common\models\finance\Billing`.
 */
class BillingSearch extends Billing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['billing_id', 'user_id', 'customer_id'], 'integer'],
            [['invoice_number', 'soa_number', 'billing_date', 'due_date'], 'safe'],
            [['amount'], 'number'],
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
        $query = Billing::find();

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
            'billing_id' => $this->billing_id,
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'billing_date' => $this->billing_date,
            'due_date' => $this->due_date,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'invoice_number', $this->invoice_number])
            ->andFilterWhere(['like', 'soa_number', $this->soa_number]);

        return $dataProvider;
    }
}
