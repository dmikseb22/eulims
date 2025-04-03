<?php

namespace common\models\help;

use Yii;

/**
 * This is the model class for table "tbl_topics_details".
 *
 * @property int $topics_details_id
 * @property int $topic_id
 * @property string $title
 * @property string $href
 * @property string $type
 *
 * @property Topics $topic
 */
class TopicsDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_topics_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic_id'], 'integer'],
            [['title', 'href'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 50],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topics::className(), 'targetAttribute' => ['topic_id' => 'topic_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'topics_details_id' => 'Topics Details ID',
            'topic_id' => 'Topic ID',
            'title' => 'Title',
            'href' => 'Href',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topics::className(), ['topic_id' => 'topic_id']);
    }
}
