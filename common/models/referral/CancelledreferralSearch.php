<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Cancelledreferral;

/**
 * CancelledreferralSearch represents the model behind the search form of `common\models\referral\Cancelledreferral`.
 */
class CancelledreferralSearch extends Cancelledreferral
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cancelledreferral_id', 'referral_id', 'agency_id', 'cancelled_by'], 'integer'],
            [['reason', 'cancel_date'], 'safe'],
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
        $query = Cancelledreferral::find();

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
            'cancelledreferral_id' => $this->cancelledreferral_id,
            'referral_id' => $this->referral_id,
            'cancel_date' => $this->cancel_date,
            'agency_id' => $this->agency_id,
            'cancelled_by' => $this->cancelled_by,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
