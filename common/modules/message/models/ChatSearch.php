<?php

namespace common\modules\message\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\message\models\Chat;

/**
 * ChatSearch represents the model behind the search form about `common\modules\message\models\Chat`.
 */
class ChatSearch extends Chat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chat_id', 'sender_userid', 'reciever_userid', 'status_id', 'group_id'], 'integer'],
            [['message', 'timestamp'], 'safe'],
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
        $query = Chat::find();

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
            'chat_id' => $this->chat_id,
            'sender_userid' => $this->sender_userid,
            'reciever_userid' => $this->reciever_userid,
            'timestamp' => $this->timestamp,
            'status_id' => $this->status_id,
            'group_id' => $this->group_id,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
