<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_tagging_analysis".
 *
 * @property int $tagging_id
 * @property int $analysis_id
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property int $tagging_status_id
 * @property string $cancel_date
 * @property string $reason
 * @property int $cancelled_by
 * @property string $disposed_date
 * @property int $iso_accredited
 * @property int $completed
 */
class Tagginganalysis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tagging_analysis';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['analysis_id', 'reason', 'cancelled_by', 'iso_accredited'], 'required'],
            [['analysis_id', 'user_id', 'tagging_status_id', 'cancelled_by', 'iso_accredited', 'completed'], 'integer'],
            [['start_date', 'end_date', 'cancel_date', 'disposed_date'], 'safe'],
            [['reason'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tagging_id' => 'Tagging ID',
            'analysis_id' => 'Analysis ID',
            'user_id' => 'User ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'tagging_status_id' => 'Tagging Status ID',
            'cancel_date' => 'Cancel Date',
            'reason' => 'Reason',
            'cancelled_by' => 'Cancelled By',
            'disposed_date' => 'Disposed Date',
            'iso_accredited' => 'Iso Accredited',
            'completed' => 'Completed',
        ];
    }
}
