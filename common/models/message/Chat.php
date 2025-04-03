<?php

namespace common\models\message;

use Yii;
use common\models\system\Profile;
/**
 * This is the model class for table "tbl_chat".
 *
 * @property int $chat_id
 * @property int $sender_userid
 * @property string $chat_data
 * @property string $timestamp
 * @property int $status_id
 * @property int $group_id
 * @property int $contact_id
 * @property int $chat_data_type
 * @property int $message_type
 *
 * @property Contacts $contact
 * @property ChatGroup $group
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_chat';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('messagedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_userid', 'chat_data', 'status_id'], 'required'],
            [['sender_userid', 'status_id', 'group_id', 'contact_id', 'chat_data_type', 'message_type'], 'integer'],
            [['chat_data'], 'string'],
            [['timestamp'], 'safe'],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contacts::className(), 'targetAttribute' => ['contact_id' => 'contact_id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatGroup::className(), 'targetAttribute' => ['group_id' => 'chat_group_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
            'sender_userid' => 'Sender Userid',
            'chat_data' => 'Chat Data',
            'timestamp' => 'Timestamp',
            'status_id' => 'Status ID',
            'group_id' => 'Group ID',
            'contact_id' => 'Contact ID',
            'chat_data_type' => 'Chat Data Type',
            'message_type' => 'Message Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contacts::className(), ['contact_id' => 'contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(ChatGroup::className(), ['chat_group_id' => 'group_id']);
    }
	
	 public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'sender_userid']);
    }
}
