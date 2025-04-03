<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Services;

/**
 * ServicesSearch represents the model behind the search form of `common\models\lab\Services`.
 */
class ServicesSearch extends Services
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['services_id', 'rstl_id', 'method_reference_id', 'sampletype_id', 'testname_method_id'], 'integer'],
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
        $query = Services::find();

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
            'services_id' => $this->services_id,
            'rstl_id' => $this->rstl_id,
            'method_reference_id' => $this->method_reference_id,
            'sampletype_id' => $this->sampletype_id,
            'testname_method_id' => $this->testname_method_id,
        ]);

        return $dataProvider;
    }
}
