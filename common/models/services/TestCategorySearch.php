<?php

namespace common\models\services;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\services\TestCategory;

/**
 * TestCategorySearch represents the model behind the search form about `common\models\lab\TestCategory`.
 */
class TestCategorySearch extends TestCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['testcategory_id', 'lab_id'], 'integer'],
            [['category_name'], 'safe'],
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
        $query = TestCategory::find();

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
            'testcategory_id' => $this->testcategory_id,
            'lab_id' => $this->lab_id,
        ]);

        $query->andFilterWhere(['like', 'category_name', $this->category_name]);

        return $dataProvider;
    }

}
