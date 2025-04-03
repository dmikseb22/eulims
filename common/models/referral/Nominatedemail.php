<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_nominatedemail".
 *
 * @property int $nominatedemail_id
 * @property int $agency_id
 * @property int $user_id
 * @property string $email
 * @property int $status
 */
class Nominatedemail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_nominatedemail';
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
            [['agency_id', 'user_id', 'email'], 'required'],
            [['agency_id', 'user_id', 'status'], 'integer'],
            [['email'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nominatedemail_id' => 'Nominatedemail ID',
            'agency_id' => 'Agency ID',
            'user_id' => 'User ID',
            'email' => 'Email',
            'status' => 'Status',
        ];
    }
}
