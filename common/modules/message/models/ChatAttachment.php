<?php

namespace common\modules\message\models;

use Yii;

/**
 * This is the model class for table "tbl_chat_attachment".
 *
 * @property int $attachment_id
 * @property string $filename
 * @property int $uploadedby_userid
 * @property string $upload_datetime
 *
 * @property Chat $uploadedbyUser
 */
class ChatAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_chat_attachment';
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
            [['uploadedby_userid','contact_group_id'], 'integer'],
            [['upload_datetime'], 'safe'],
            [['filename'], 'string', 'max' => 100],
            [['uploadedby_userid'], 'exist', 'skipOnError' => true, 'targetClass' => Chat::className(), 'targetAttribute' => ['uploadedby_userid' => 'sender_userid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => 'Attachment ID',
            'filename' => 'Filename',
            'uploadedby_userid' => 'Uploadedby Userid',
            'upload_datetime' => 'Upload Datetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUploadedbyUser()
    {
        return $this->hasOne(Chat::className(), ['sender_userid' => 'uploadedby_userid']);
    }
}
