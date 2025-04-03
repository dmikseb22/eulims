<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Lab;

/**
 * LabSearch represents the model behind the search form about `common\models\lab\Lab`.
 */
class LabSearch extends Lab
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lab_id', 'labcount', 'active'], 'integer'],
            [['labname', 'labcode', 'nextrequestcode'], 'safe'],
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
        $query = Lab::find();

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
            'lab_id' => $this->lab_id,
            'labcount' => $this->labcount,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'labname', $this->labname])
            ->andFilterWhere(['like', 'labcode', $this->labcode])
            ->andFilterWhere(['like', 'nextrequestcode', $this->nextrequestcode]);

        return $dataProvider;
    }
}
