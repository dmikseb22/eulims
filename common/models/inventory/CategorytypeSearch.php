<?php

namespace common\models\inventory;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\inventory\Categorytype;

/**
 * CategorytypeSearch represents the model behind the search form about `common\models\inventory\Categorytype`.
 */
class CategorytypeSearch extends Categorytype
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categorytype_id'], 'integer'],
            [['categorytype', 'description'], 'safe'],
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
        $query = Categorytype::find();

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
            'categorytype_id' => $this->categorytype_id,
        ]);

        $query->andFilterWhere(['like', 'categorytype', $this->categorytype])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
