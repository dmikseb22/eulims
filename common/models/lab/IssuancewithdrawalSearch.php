<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Issuancewithdrawal;

/**
 * IssuancewithdrawalSearch represents the model behind the search form of `common\models\lab\Issuancewithdrawal`.
 */
class IssuancewithdrawalSearch extends Issuancewithdrawal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['issuancewithdrawal_id'], 'integer'],
            [['document_code', 'title', 'rev_no', 'copy_holder', 'copy_no', 'issuance', 'withdrawal', 'date', 'name'], 'safe'],
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
        $query = Issuancewithdrawal::find();

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
            'issuancewithdrawal_id' => $this->issuancewithdrawal_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'document_code', $this->document_code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'rev_no', $this->rev_no])
            ->andFilterWhere(['like', 'copy_holder', $this->copy_holder])
            ->andFilterWhere(['like', 'copy_no', $this->copy_no])
            ->andFilterWhere(['like', 'issuance', $this->issuance])
            ->andFilterWhere(['like', 'withdrawal', $this->withdrawal])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
