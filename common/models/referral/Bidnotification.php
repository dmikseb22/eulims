<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_bid_notification".
 *
 * @property int $bid_notification_id
 * @property int $referral_id
 * @property int $bid_notification_type_id
 * @property int $postedby_agency_id
 * @property string $posted_at
 * @property int $recipient_agency_id
 * @property int $sender_user_id
 * @property int $seen
 * @property string $seen_date
 */
class Bidnotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bid_notification';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('referraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referral_id', 'bid_notification_type_id', 'postedby_agency_id', 'posted_at', 'recipient_agency_id', 'sender_user_id'], 'required'],
            [['referral_id', 'bid_notification_type_id', 'postedby_agency_id', 'recipient_agency_id', 'sender_user_id', 'seen'], 'integer'],
            [['posted_at', 'seen_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bid_notification_id' => 'Bid Notification ID',
            'referral_id' => 'Referral ID',
            'bid_notification_type_id' => 'Bid Notification Type ID',
            'postedby_agency_id' => 'Postedby Agency ID',
            'posted_at' => 'Posted At',
            'recipient_agency_id' => 'Recipient Agency ID',
            'sender_user_id' => 'Sender User ID',
            'seen' => 'Seen',
            'seen_date' => 'Seen Date',
        ];
    }
}
