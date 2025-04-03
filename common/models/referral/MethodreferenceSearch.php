<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Methodreference;

/**
 * MethodreferenceSearch represents the model behind the search form of `common\models\referral\Methodreference`.
 */
class MethodreferenceSearch extends Methodreference
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['methodreference_id'], 'integer'],
            [['method', 'reference', 'create_time', 'update_time'], 'safe'],
            [['fee'], 'number'],
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
        $query = Methodreference::find();

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
            'methodreference_id' => $this->methodreference_id,
            'fee' => $this->fee,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'method', $this->method])
            ->andFilterWhere(['like', 'reference', $this->reference]);

        return $dataProvider;
    }
}
