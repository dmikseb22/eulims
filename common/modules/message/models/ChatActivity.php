<?php

namespace common\modules\message\models;

use Yii;

/**
 * This is the model class for table "tbl_chat_activity_details".
 *
 * @property int $id
 * @property int $userid
 * @property string $last_activity
 * @property string $is_typing
 *
 * @property Chat $user
 */
class ChatActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_chat_activity_details';
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
            [['id', 'userid', 'is_typing'], 'required'],
            [['id', 'userid'], 'integer'],
            [['last_activity'], 'safe'],
            [['is_typing'], 'string'],
            [['id'], 'unique'],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => Chat::className(), 'targetAttribute' => ['userid' => 'sender_userid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'last_activity' => 'Last Activity',
            'is_typing' => 'Is Typing',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Chat::className(), ['sender_userid' => 'userid']);
    }
}
