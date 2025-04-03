<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Packageoffer;

/**
 * PackageofferSearch represents the model behind the search form of `common\models\referral\Packageoffer`.
 */
class PackageofferSearch extends Packageoffer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['packageoffer_id', 'agency_id', 'packagelist_id'], 'integer'],
            [['offered_date'], 'safe'],
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
        $query = Packageoffer::find();

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
            'packageoffer_id' => $this->packageoffer_id,
            'agency_id' => $this->agency_id,
            'packagelist_id' => $this->packagelist_id,
            'offered_date' => $this->offered_date,
        ]);

        return $dataProvider;
    }
}
