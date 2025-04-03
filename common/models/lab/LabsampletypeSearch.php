<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Labsampletype;

/**
 * LabsampletypeSearch represents the model behind the search form of `common\models\lab\Labsampletype`.
 */
class LabsampletypeSearch extends Labsampletype
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lab_sampletype_id', 'lab_id', 'sampletype_id', 'testcategory_id'], 'integer'],
            [['effective_date', 'added_by'], 'safe'],
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
        $query = Labsampletype::find();

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
            'lab_sampletype_id' => $this->lab_sampletype_id,
            'lab_id' => $this->lab_id,
            'sampletype_id' => $this->sampletype_id,
            'effective_date' => $this->effective_date,
            'testcategory_id' => $this->testcategory_id,
        ]);

        $query->andFilterWhere(['like', 'added_by', $this->added_by]);

        return $dataProvider;
    }
}
