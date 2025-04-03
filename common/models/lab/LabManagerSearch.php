<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\LabManager;

/**
 * LabManagerSearch represents the model behind the search form about `common\models\lab\LabManager`.
 */
class LabManagerSearch extends LabManager
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lab_manager_id', 'lab_id', 'user_id', 'updated_at'], 'integer'],
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
        $query = LabManager::find();

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
            'lab_manager_id' => $this->lab_manager_id,
            'lab_id' => $this->lab_id,
            'user_id' => $this->user_id,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
