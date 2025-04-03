<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\Soa;

/**
 * SoaSearch represents the model behind the search form about `common\models\finance\Soa`.
 */
class SoaSearch extends Soa
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['soa_id', 'customer_id', 'user_id'], 'integer'],
            ['active', 'default', 'value' => self::STATUS_ACTIVE],
            ['active', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            [['soa_date','payment_due_date', 'soa_number', 'active'], 'safe'],
            [['previous_balance', 'current_amount', 'payment_amount', 'total_amount'], 'number'],
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
        $query = Soa::find();

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
            'soa_id' => $this->soa_id,
            'soa_date' => $this->soa_date,
            'payment_due_date' => $this->payment_due_date,
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
            'previous_balance' => $this->previous_balance,
            'current_amount' => $this->current_amount,
            'payment_amount' => $this->payment_amount,
            'total_amount' => $this->total_amount,
            'active'=> self::STATUS_ACTIVE
        ]);

        $query->andFilterWhere(['like', 'soa_number', $this->soa_number])
            ->andFilterWhere(['like', 'payment_due_date', $this->payment_due_date])
            ->andFilterWhere(['like', 'active', $this->active]);

        return $dataProvider;
    }
}
