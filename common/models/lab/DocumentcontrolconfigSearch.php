<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Documentcontrolconfig;

/**
 * DocumentcontrolconfigSearch represents the model behind the search form of `common\models\lab\Documentcontrolconfig`.
 */
class DocumentcontrolconfigSearch extends Documentcontrolconfig
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documentcontrolconfig_id'], 'integer'],
            [['dcf', 'year', 'custodian', 'approved'], 'safe'],
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
        $query = Documentcontrolconfig::find();

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
            'documentcontrolconfig_id' => $this->documentcontrolconfig_id,
        ]);

        $query->andFilterWhere(['like', 'dcf', $this->dcf])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'custodian', $this->custodian])
            ->andFilterWhere(['like', 'approved', $this->approved]);

        return $dataProvider;
    }
}
