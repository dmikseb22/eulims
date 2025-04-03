<?php

namespace common\models\services;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\services\Sampletype;

/**
 * SampletypeSearch represents the model behind the search form about `common\models\services\Sampletype`.
 */
class SampletypeSearch extends Sampletype
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sampletype_id', 'testcategory_id'], 'integer'],
            [['sample_type'], 'safe'],
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
        $query = Sampletype::find();

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
            'sample_type_id' => $this->sample_type_id,
            'testcategory_id' => $this->testcategory_id,
        ]);

        $query->andFilterWhere(['like', 'sample_type', $this->sample_type]);

        return $dataProvider;
    }
}
