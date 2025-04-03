<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Formrequest;

/**
 * FormrequestSearch represents the model behind the search form of `common\models\referral\Formrequest`.
 */
class FormrequestSearch extends Formrequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['formrequest_id', 'agency_id', 'print_format'], 'integer'],
            [['title', 'number', 'rev_num', 'rev_date', 'logo_left', 'logo_right'], 'safe'],
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
        $query = Formrequest::find();

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
            'formrequest_id' => $this->formrequest_id,
            'agency_id' => $this->agency_id,
            'print_format' => $this->print_format,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'rev_num', $this->rev_num])
            ->andFilterWhere(['like', 'rev_date', $this->rev_date])
            ->andFilterWhere(['like', 'logo_left', $this->logo_left])
            ->andFilterWhere(['like', 'logo_right', $this->logo_right]);

        return $dataProvider;
    }
}
