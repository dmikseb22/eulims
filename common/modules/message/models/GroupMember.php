<?php

namespace common\modules\message\models;

use Yii;

/**
 * This is the model class for table "tbl_group_member".
 *
 * @property int $group_id
 * @property int $chat_group_id
 * @property int $user_id
 *
 * @property Chat[] $chats
 * @property ChatGroup $chatGroup
 */
class GroupMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_group_member';
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
            [['chat_group_id', 'user_id'], 'integer'],
            [['chat_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatGroup::className(), 'targetAttribute' => ['chat_group_id' => 'chat_group_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'chat_group_id' => 'Chat Group ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['group_id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatGroup()
    {
        return $this->hasOne(ChatGroup::className(), ['chat_group_id' => 'chat_group_id']);
    }
}
