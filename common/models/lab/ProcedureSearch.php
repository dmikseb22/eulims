<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Procedure;

/**
 * ProcedureSearch represents the model behind the search form of `common\models\lab\Procedure`.
 */
class ProcedureSearch extends Procedure
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['procedure_id', 'testname_id', 'testname_method_id'], 'integer'],
            [['procedure_name', 'procedure_code'], 'safe'],
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
        $query = Procedure::find();

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
            'procedure_id' => $this->procedure_id,
            'testname_id' => $this->testname_id,
            'testname_method_id' => $this->testname_method_id,
        ]);

        $query->andFilterWhere(['like', 'procedure_name', $this->procedure_name])
            ->andFilterWhere(['like', 'procedure_code', $this->procedure_code]);

        return $dataProvider;
    }
}
