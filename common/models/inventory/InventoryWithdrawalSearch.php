<?php

namespace common\models\inventory;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\inventory\InventoryWithdrawal;

/**
 * InventoryWithdrawalSearch represents the model behind the search form of `common\models\inventory\InventoryWithdrawal`.
 */
class InventoryWithdrawalSearch extends InventoryWithdrawal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventory_withdrawal_id', 'created_by', 'lab_id', 'total_qty'], 'integer'],
            [['withdrawal_datetime', 'remarks'], 'safe'],
            [['total_cost'], 'number'],
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
        $query = InventoryWithdrawal::find();

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
            'inventory_withdrawal_id' => $this->inventory_withdrawal_id,
            'created_by' => $this->created_by,
            'withdrawal_datetime' => $this->withdrawal_datetime,
            'lab_id' => $this->lab_id,
            'total_qty' => $this->total_qty,
            'total_cost' => $this->total_cost,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
