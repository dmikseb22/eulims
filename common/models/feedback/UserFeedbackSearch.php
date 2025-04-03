<?php

namespace common\models\feedback;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\feedback\UserFeedback;

/**
 * UserFeedbackSearch represents the model behind the search form about `common\models\feedback\UserFeedback`.
 */
class UserFeedbackSearch extends UserFeedback
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feedback_id'], 'integer'],
            [['url', 'urlpath_screen', 'details', 'steps', 'reported_by', 'region_reported', 'action_taken'], 'safe'],
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
        $query = UserFeedback::find();

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
            'feedback_id' => $this->feedback_id,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'urlpath_screen', $this->urlpath_screen])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'steps', $this->steps])
            ->andFilterWhere(['like', 'reported_by', $this->reported_by])
            ->andFilterWhere(['like', 'region_reported', $this->region_reported])
            ->andFilterWhere(['like', 'action_taken', $this->action_taken]);

        return $dataProvider;
    }
}
