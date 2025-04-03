<?php

namespace common\models\finance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\finance\Customerwallet;
// use common\models\lab\Customer;


/**
 * CustomerwalletSearch represents the model behind the search form about `common\models\finance\Customerwallet`.
 */
class CustomerwalletSearch extends Customerwallet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerwallet_id'], 'integer'],
            [['date', 'last_update', 'customer_id'], 'safe'],
            [['balance'], 'number'],
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
        $query = Customerwallet::find(Yii::$app->financedb);
        // $query = Customerwallet::find()->joinWith("customer")->one(Yii::$app->labdb);

        // var_dump($query);
        // exit();
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

        // $relatedItems = $query->Customer()->all(Yii::$app->db2);

        // $query->joinwith('customer')->one(Yii::$app->labdb);
        // $query->joinwith('customer')->joinWith("customer")->where(["customer_id"=>"t.customer_id"])->createCommand(Yii::$app->labdb)->getRawSql();

        // grid filtering conditions
        $query->andFilterWhere([
            'customerwallet_id' => $this->customerwallet_id,
            // 'date' => $this->date,
            // 'last_update' => $this->last_update,
            'balance' => $this->balance,
            'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like','date',$this->date]);
         $query->andFilterWhere(['like','last_update',$this->last_update]);

        return $dataProvider;
    }
}
