<?php

namespace common\models\inventory;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\inventory\Equipmentservice;

/**
 * EquipmentserviceSearch represents the model behind the search form of `common\models\inventory\Equipmentservice`.
 */
class EquipmentserviceSearch extends Equipmentservice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipmentservice_id', 'inventory_transactions_id', 'servicetype_id', 'requested_by', 'startdate', 'enddate', 'request_status'], 'integer'],
            [['attachment'], 'safe'],
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
        $query = Equipmentservice::find();

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
            'equipmentservice_id' => $this->equipmentservice_id,
            'inventory_transactions_id' => $this->inventory_transactions_id,
            'servicetype_id' => $this->servicetype_id,
            'requested_by' => $this->requested_by,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'request_status' => $this->request_status,
        ]);

        $query->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
