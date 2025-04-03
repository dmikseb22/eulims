<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\testpackage;

/**
 * TestpackageSearch represents the model behind the search form of `common\models\lab\testpackage`.
 */
class TestpackageSearch extends testpackage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['testpackage_id', 'lab_sampletype_id', 'package_rate', 'testname_methods', 'added_by'], 'integer'],
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
        $query = testpackage::find();

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
            'testpackage_id' => $this->testpackage_id,
            'lab_sampletype_id' => $this->lab_sampletype_id,
            'package_rate' => $this->package_rate,
            'testname_methods' => $this->testname_methods,
            'added_by' => $this->added_by,
        ]);

        return $dataProvider;
    }
}
