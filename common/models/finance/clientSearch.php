<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\client;

/**
 * clientSearch represents the model behind the search form about `common\models\finance\client`.
 */
class clientSearch extends client
{
    public $StartDate;
    public $EndDate;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'customer_id'], 'integer'],
            [['account_number', 'company_name', 'signature_date', 'signed', 'active','StartDate','EndDate'], 'safe'],
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
        $query = client::find();

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
            'client_id' => $this->client_id
        ]);
        
        $query->andFilterWhere(['like', 'account_number', $this->account_number])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
           ->andFilterWhere(['=', 'customer_id', $this->customer_id])    
            ->andFilterWhere(['between', 'signature_date', $this->StartDate, $this->EndDate]);

        return $dataProvider;
    }
}
