<?php

namespace common\models\system;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\system\PackageDetails;

/**
 * PackageDetailsSearch represents the model behind the search form about `common\models\system\PackageDetails`.
 */
class PackageDetailsSearch extends PackageDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Package_DetailID', 'PackageID', 'created_at', 'updated_at'], 'integer'],
            [['Package_Detail', 'icon'], 'safe'],
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
        $query = PackageDetails::find();

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
            'Package_DetailID' => $this->Package_DetailID,
            'PackageID' => $this->PackageID,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'Package_Detail', $this->Package_Detail])
            ->andFilterWhere(['like', 'icon', $this->icon]);

        return $dataProvider;
    }
}
