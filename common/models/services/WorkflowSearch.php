<?php

namespace common\models\services;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\services\Workflow;

/**
 * WorkflowSearch represents the model behind the search form of `common\models\services\Workflow`.
 */
class WorkflowSearch extends Workflow
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workflow_id', 'test_id'], 'integer'],
            [['method', 'workflow'], 'safe'],
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
        $query = Workflow::find();

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
            'workflow_id' => $this->workflow_id,
            'test_id' => $this->test_id,
        ]);

        $query->andFilterWhere(['like', 'method', $this->method])
            ->andFilterWhere(['like', 'workflow', $this->workflow]);

        return $dataProvider;
    }
}
