<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Testnamemethod;

/**
 * TestnamemethodSearch represents the model behind the search form of `common\models\referral\Testnamemethod`.
 */
class TestnamemethodSearch extends Testnamemethod
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['testname_method_id', 'testname_id', 'methodreference_id'], 'integer'],
            [['added_by', 'create_time', 'update_time'], 'safe'],
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
        $query = Testnamemethod::find();

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
            'testname_method_id' => $this->testname_method_id,
            'testname_id' => $this->testname_id,
            'methodreference_id' => $this->methodreference_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'added_by', $this->added_by]);

        return $dataProvider;
    }
}
