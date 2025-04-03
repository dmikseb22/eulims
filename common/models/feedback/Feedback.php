<?php

namespace common\models\feedback;

use Yii;

/**
 * This is the model class for table "tbl_feedback".
 *
 * @property int $feedback_id
 * @property string $url
 * @property string $urlpath_screen
 * @property string $details
 * @property string $steps
 * @property string $reported_by
 * @property string $region_reported
 * @property string $action_taken
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'urlpath_screen', 'details', 'steps'], 'string'],
            [['reported_by', 'action_taken'], 'string', 'max' => 250],
            [['region_reported'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'feedback_id' => 'Feedback ID',
            'url' => 'Url',
            'urlpath_screen' => 'Urlpath Screen',
            'details' => 'Details',
            'steps' => 'Steps',
            'reported_by' => 'Reported By',
            'region_reported' => 'Region Reported',
            'action_taken' => 'Action Taken',
        ];
    }
}
