<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\Check;

/**
 * CheckSearch represents the model behind the search form about `common\models\finance\Check`.
 */
class CheckSearch extends Check
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['check_id', 'receipt_id'], 'integer'],
            [['bank', 'checknumber', 'checkdate'], 'safe'],
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
        $query = Check::find();

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
            'check_id' => $this->check_id,
            'receipt_id' => $this->receipt_id,
            'checkdate' => $this->checkdate,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'checknumber', $this->checknumber]);

        return $dataProvider;
    }
}
