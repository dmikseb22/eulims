<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_pstcattachment".
 *
 * @property int $pstc_attachment_id
 * @property string $filename
 * @property int $pstc_request_id
 * @property int $uploadedby_user_id
 * @property string $uploadedby_name
 * @property string $upload_date
 */
class Pstcattachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_pstcattachment';
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
            [['filename', 'pstc_request_id', 'uploadedby_user_id', 'uploadedby_name', 'upload_date'], 'required'],
            [['pstc_request_id', 'uploadedby_user_id'], 'integer'],
            [['upload_date'], 'safe'],
            [['filename'], 'string', 'max' => 400],
            [['uploadedby_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pstc_attachment_id' => 'Pstc Attachment ID',
            'filename' => 'Filename',
            'pstc_request_id' => 'Pstc Request ID',
            'uploadedby_user_id' => 'Uploadedby User ID',
            'uploadedby_name' => 'Uploadedby Name',
            'upload_date' => 'Upload Date',
        ];
    }

    public function getRequest()
    {
        return $this->hasOne(Pstcrequest::className(), ['pstc_request_id' => 'pstc_request_id']);
    }
}
