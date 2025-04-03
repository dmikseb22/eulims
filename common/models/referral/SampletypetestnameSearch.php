<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Sampletypetestname;

/**
 * SampletypetestnameSearch represents the model behind the search form of `common\models\referral\Sampletypetestname`.
 */
class SampletypetestnameSearch extends Sampletypetestname
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sampletypetestname_id', 'sampletype_id', 'testname_id'], 'integer'],
            [['added_by', 'date_added'], 'safe'],
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
        $query = Sampletypetestname::find();

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
            'sampletypetestname_id' => $this->sampletypetestname_id,
            'sampletype_id' => $this->sampletype_id,
            'testname_id' => $this->testname_id,
            'date_added' => $this->date_added,
        ]);

        $query->andFilterWhere(['like', 'added_by', $this->added_by]);

        return $dataProvider;
    }
}
