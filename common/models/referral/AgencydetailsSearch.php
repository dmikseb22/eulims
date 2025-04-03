<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Agencydetails;

/**
 * AgencydetailsSearch represents the model behind the search form of `common\models\referral\Agencydetails`.
 */
class AgencydetailsSearch extends Agencydetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agencydetails_id', 'agency_id'], 'integer'],
            [['name', 'address', 'contacts', 'short_name', 'lab_name', 'labtype_short', 'description'], 'safe'],
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
        $query = Agencydetails::find();

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
            'agencydetails_id' => $this->agencydetails_id,
            'agency_id' => $this->agency_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'lab_name', $this->lab_name])
            ->andFilterWhere(['like', 'labtype_short', $this->labtype_short])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
