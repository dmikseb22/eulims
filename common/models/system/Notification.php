<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "tbl_notification".
 *
 * @property int $opnotification_id
 * @property int $request_id
 * @property int $op_id
 * @property int $receipt_id
 * @property int $sender_id
 * @property string $sender_name
 * @property int $op_respondent_id
 * @property int $payment_respondent_id
 * @property string $remarks
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'sender_id', 'sender_name', 'notification_date'], 'required'],
            [['request_id', 'op_id', 'receipt_id', 'sender_id', 'op_respondent_id', 'payment_respondent_id'], 'integer'],
            [['notification_date'], 'safe'],
            [['sender_name'], 'string', 'max' => 100],
            [['remarks'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'opnotification_id' => 'Opnotification ID',
            'request_id' => 'Request ID',
            'op_id' => 'Op ID',
            'receipt_id' => 'Receipt ID',
            'sender_id' => 'Sender ID',
            'sender_name' => 'Sender Name',
            'op_respondent_id' => 'Op Respondent ID',
            'payment_respondent_id' => 'Payment Respondent ID',
            'remarks' => 'Remarks',
            'notification_date' => 'Notification Date',
        ];
    }
}
