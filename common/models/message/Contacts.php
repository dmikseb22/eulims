<?php

namespace common\models\message;

use Yii;

/**
 * This is the model class for table "tbl_contacts".
 *
 * @property int $contact_id
 * @property string $user_id
 * @property int $user_idtwo
 * @property string $timestamp
 *
 * @property Chat[] $chats
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_contacts';
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
            [['user_id'], 'required'],
            [['timestamp'], 'safe'],
            [['user_id'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contact_id' => 'Contact ID',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['contact_id' => 'contact_id']);
    }
}
