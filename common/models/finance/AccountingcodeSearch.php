<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\Accountingcode;

/**
 * AccountingcodeSearch represents the model behind the search form of `common\models\finance\Accountingcode`.
 */
class AccountingcodeSearch extends Accountingcode
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accountingcode_id'], 'integer'],
            [['accountcode', 'accountdesc'], 'safe'],
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
        $query = Accountingcode::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                            'pageSize' => 5,
                            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'accountingcode_id' => $this->accountingcode_id,
        ]);

        $query->andFilterWhere(['like', 'accountcode', $this->accountcode])
            ->andFilterWhere(['like', 'accountdesc', $this->accountdesc]);

        return $dataProvider;
    }
}
