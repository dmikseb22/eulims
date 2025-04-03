<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\Collectiontype;

/**
 * CollectiontypeSearch represents the model behind the search form about `common\models\finance\Collectiontype`.
 */
class CollectiontypeSearch extends Collectiontype
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collectiontype_id', 'status'], 'integer'],
            [['natureofcollection'], 'safe'],
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
        $query = Collectiontype::find();

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
            'collectiontype_id' => $this->collectiontype_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'natureofcollection', $this->natureofcollection]);

        return $dataProvider;
    }
}
