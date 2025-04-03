<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Packagelist;

/**
 * PackagelistSearch represents the model behind the search form of `common\models\lab\Packagelist`.
 */
class PackagelistSearch extends Packagelist
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'rstl_id'], 'integer'],
            [['name', 'tests'], 'safe'],
            [['rate'], 'number'],
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
        $query = Packagelist::find();

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
            'package_id' => $this->package_id,
            'rstl_id' => $this->rstl_id,
            'rate' => $this->rate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tests', $this->tests]);

        return $dataProvider;
    }
}
