<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Cancelledrequest;

/**
 * CancelledrequestSearch represents the model behind the search form about `common\models\lab\Cancelledrequest`.
 */
class CancelledrequestSearch extends Cancelledrequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['canceledrequest_id', 'request_id', 'cancelledby'], 'integer'],
            [['request_ref_num', 'reason', 'cancel_date'], 'safe'],
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
        $query = Cancelledrequest::find();

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
            'canceledrequest_id' => $this->canceledrequest_id,
            'request_id' => $this->request_id,
            'cancel_date' => $this->cancel_date,
            'cancelledby' => $this->cancelledby,
        ]);

        $query->andFilterWhere(['like', 'request_ref_num', $this->request_ref_num])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
