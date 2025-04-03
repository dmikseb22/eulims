<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\Bankaccount;

/**
 * BankaccountSearch represents the model behind the search form of `common\models\finance\Bankaccount`.
 */
class BankaccountSearch extends Bankaccount
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bankaccount_id', 'rstl_id'], 'integer'],
            [['bank_name', 'account_number'], 'safe'],
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
        $query = Bankaccount::find();

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
            'bankaccount_id' => $this->bankaccount_id,
            'rstl_id' => $this->rstl_id,
        ]);

        $query->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'account_number', $this->account_number]);

        return $dataProvider;
    }
}
