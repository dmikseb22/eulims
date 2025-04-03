<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Testnamemethod;
use linslin\yii2\curl;

/**
 * TestnamemethodSearch represents the model behind the search form of `common\models\lab\Testnamemethod`.
 */
class TestnamemethodSearch extends Testnamemethod
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['testname_method_id', 'testname_id', 'method_id', 'lab_id', 'sampletype_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
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
        $query = Testnamemethod::find();

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
            'testname_method_id' => $this->testname_method_id,
            'testname_id' => $this->testname_id,
            'method_id' => $this->method_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'lab_id'=>$this->lab_id,
            'sampletype_id'=>$this->sampletype_id,
        ]);

        return $dataProvider;
    }

    public static function checking($id){

        $curl = new curl\Curl();
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
        $curl->setOption(CURLOPT_TIMEOUT, 180);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $response = $curl->setGetParams(['id' => Yii::$app->user->identity->profile->rstl_id.'-'.$id,])->get($GLOBALS['local_api_url']."restpstc/checkmethod");

    }
}
