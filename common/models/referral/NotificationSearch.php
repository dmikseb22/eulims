<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Notification;

/**
 * NotificationSearch represents the model behind the search form of `common\models\referral\Notification`.
 */
class NotificationSearch extends Notification
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notification_id', 'referral_id', 'notification_type_id', 'recipient_id', 'sender_id', 'seen'], 'integer'],
            [['sender_name', 'remarks', 'notification_date'], 'safe'],
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
        $query = Notification::find();

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
            'notification_id' => $this->notification_id,
            'referral_id' => $this->referral_id,
            'notification_type_id' => $this->notification_type_id,
            'recipient_id' => $this->recipient_id,
            'sender_id' => $this->sender_id,
            'seen' => $this->seen,
            'notification_date' => $this->notification_date,
        ]);

        $query->andFilterWhere(['like', 'sender_name', $this->sender_name])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
