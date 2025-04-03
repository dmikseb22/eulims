<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\BackuprestoreLogs;

/**
 * BackuprestoreLogsSearch represents the model behind the search form about `common\models\finance\BackuprestoreLogs`.
 */
class BackuprestoreLogsSearch extends BackuprestoreLogs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['activity', 'transaction_date', 'data_date', 'op', 'paymentitem', 'receipt', 'check', 'deposit', 'status'], 'safe'],
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
        $query = BackuprestoreLogs::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'activity', $this->activity])
            ->andFilterWhere(['like', 'transaction_date', $this->transaction_date])
            ->andFilterWhere(['like', 'data_date', $this->data_date])
            ->andFilterWhere(['like', 'op', $this->op])
            ->andFilterWhere(['like', 'paymentitem', $this->paymentitem])
            ->andFilterWhere(['like', 'receipt', $this->receipt])
            ->andFilterWhere(['like', 'check', $this->check])
            ->andFilterWhere(['like', 'deposit', $this->deposit])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
