<?php

namespace common\models\help;

use Yii;

/**
 * This is the model class for table "tbl_topics".
 *
 * @property int $topic_id
 * @property string $details
 *
 * @property TopicsDetails[] $topicsDetails
 */
class Topics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_topics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['details'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'topic_id' => 'Topic ID',
            'details' => 'Details',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicsDetails()
    {
        return $this->hasMany(TopicsDetails::className(), ['topic_id' => 'topic_id']);
    }
}
