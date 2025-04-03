<?php

namespace common\models\referral;

use Yii;
use common\models\referral\Agency;

/**
 * This is the model class for table "tbl_notification".
 *
 * @property int $notification_id
 * @property int $referral_id
 * @property int $notificationtype_id
 * @property int $recipient_id
 * @property int $sender_user_id
 * @property string $sender_name
 * @property string $remarks
 * @property int $responded
 * @property string $notification_date
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_notification';
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
            [['referral_id', 'notification_type_id', 'sender_id', 'recipient_id', 'sender_user_id', 'sender_name', 'notification_date'], 'required'],
            [['referral_id', 'notification_type_id', 'sender_id', 'recipient_id', 'sender_user_id', 'responded'], 'integer'],
            [['notification_date'], 'safe'],
            [['sender_name', 'remarks'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'Notification ID',
            'referral_id' => 'Referral ID',
            'notificationtype_id' => 'Notificationtype ID',
            'recipient_id' => 'Recipient ID',
            'sender_user_id' => 'Sender User ID',
            'sender_name' => 'Sender Name',
            'remarks' => 'Remarks',
            'responded' => 'Responded',
            'notification_date' => 'Notification Date',
        ];
    }
    
    public function getReferral()
    {
        return $this->hasOne(Referral::className(), ['referral_id' => 'referral_id']);
    }
    public function getAgencysender()
    {
        return $this->hasOne(Agency::className(), ['agency_id' => 'sender_id']);
    }
    public function getAgencyrecipient()
    {
        return $this->hasOne(Agency::className(), ['agency_id' => 'recipient_id']);
    }
}
