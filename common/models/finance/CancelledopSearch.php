<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\CancelledOp;

/**
 * CancelledrequestSearch represents the model behind the search form about `common\models\lab\Cancelledrequest`.
 */
class CancelledopSearch extends CancelledOp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [['orderofpayment_id', 'transactionnum', 'reason', 'cancel_date', 'cancelledby'], 'required'],
            [['orderofpayment_id', 'cancelledby'], 'integer'],
            [['reason'], 'string'],
            [['cancel_date'], 'safe'],
            [['transactionnum'], 'string', 'max' => 100],
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
        $query = CancelledOp::find();

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
            'cancelled_op_id' => $this->cancelled_op_id,
            'orderofpayment_id' => $this->orderofpayment_id,
            'cancel_date' => $this->cancel_date,
            'cancelledby' => $this->cancelledby,
        ]);

        $query->andFilterWhere(['like', 'transactionnum', $this->transactionnum])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
