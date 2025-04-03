<?php

namespace common\models\services;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\services\Test;

/**
 * TestSearch represents the model behind the search form about `common\models\services\Test`.
 */
class TestSearch extends Test
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_id', 'rstl_id', 'duration', 'testcategory_id', 'sample_type_id', 'lab_id'], 'integer'],
            [['testname', 'payment_references'], 'safe'],
            [['fee'], 'number'],
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
        $query = Test::find();

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
            'test_id' => $this->test_id,
            'rstl_id' => $this->rstl_id,
            'fee' => $this->fee,
            'duration' => $this->duration,
            'testcategory_id' => $this->testcategory_id,
            'sample_type_id' => $this->sample_type_id,
            'lab_id' => $this->lab_id,
        ]);

        $query->andFilterWhere(['like', 'testname', $this->testname])
            ->andFilterWhere(['like', 'payment_references', $this->payment_references]);

        return $dataProvider;
    }
}
