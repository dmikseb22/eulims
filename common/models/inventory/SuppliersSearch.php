<?php

namespace common\models\inventory;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\inventory\Suppliers;

/**
 * SuppliersSearch represents the model behind the search form of `common\models\inventory\Suppliers`.
 */
class SuppliersSearch extends Suppliers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['suppliers_id'], 'integer'],
            [['suppliers', 'description', 'address', 'contact_person', 'phone_number', 'fax_number', 'email'], 'safe'],
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
        $query = Suppliers::find();

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
            'suppliers_id' => $this->suppliers_id,
        ]);

        $query->andFilterWhere(['like', 'suppliers', $this->suppliers])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'fax_number', $this->fax_number])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
