<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Testcategory;

/**
 * TestcategorySearch represents the model behind the search form of `common\models\lab\Testcategory`.
 */
class TestcategorySearch extends Testcategory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['testcategory_id'], 'integer'],
            [['category'], 'safe'],
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
        $query = Testcategory::find();

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
            'testcategory_id' => $this->testcategory_id,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }
} 

?>