<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Documentcontrol;

/**
 * DocumentcontrolSearch represents the model behind the search form of `common\models\lab\Documentcontrol`.
 */
class DocumentcontrolSearch extends Documentcontrol
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documentcontrol_id'], 'integer'],
            [['originator', 'date_requested', 'division', 'code_num', 'title', 'previous_rev_num', 'new_revision_no', 'pages_revised', 'effective_date', 'reason', 'description', 'reviewed_by', 'approved_by', 'dcf_no', 'custodian'], 'safe'],
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
        $query = Documentcontrol::find();

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
            'documentcontrol_id' => $this->documentcontrol_id,
            'date_requested' => $this->date_requested,
            'effective_date' => $this->effective_date,
        ]);

        $query->andFilterWhere(['like', 'originator', $this->originator])
            ->andFilterWhere(['like', 'division', $this->division])
            ->andFilterWhere(['like', 'code_num', $this->code_num])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'previous_rev_num', $this->previous_rev_num])
            ->andFilterWhere(['like', 'new_revision_no', $this->new_revision_no])
            ->andFilterWhere(['like', 'pages_revised', $this->pages_revised])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'reviewed_by', $this->reviewed_by])
            ->andFilterWhere(['like', 'approved_by', $this->approved_by])
            ->andFilterWhere(['like', 'dcf_no', $this->dcf_no])
            ->andFilterWhere(['like', 'custodian', $this->custodian]);

        return $dataProvider;
    }
}
