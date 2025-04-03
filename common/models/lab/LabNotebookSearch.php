<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\LabNotebook;

/**
 * LabNotebookSearch represents the model behind the search form of `common\models\lab\LabNotebook`.
 */
class LabNotebookSearch extends LabNotebook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notebook_id', 'created_by'], 'integer'],
            [['notebook_name', 'description', 'date_created', 'file'], 'safe'],
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
        $query = LabNotebook::find();

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
            'notebook_id' => $this->notebook_id,
            'date_created' => $this->date_created,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'notebook_name', $this->notebook_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
