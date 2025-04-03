<?php

namespace common\models\referral;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\referral\Attachment;

/**
 * AttachmentSearch represents the model behind the search form of `common\models\referral\Attachment`.
 */
class AttachmentSearch extends Attachment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attachment_id', 'filetype', 'referral_id', 'upload_by'], 'integer'],
            [['filename', 'upload_date'], 'safe'],
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
        $query = Attachment::find();

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
            'attachment_id' => $this->attachment_id,
            'filetype' => $this->filetype,
            'referral_id' => $this->referral_id,
            'upload_date' => $this->upload_date,
            'upload_by' => $this->upload_by,
        ]);

        $query->andFilterWhere(['like', 'filename', $this->filename]);

        return $dataProvider;
    }
}
