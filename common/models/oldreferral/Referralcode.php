<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "referralcode".
 *
 * @property int $id
 * @property int $referral_id
 * @property string $referralCode
 * @property int $agency_id
 * @property int $lab_id
 * @property int $number
 * @property int $year
 * @property string $created_at
 */
class Referralcode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referralcode';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('oldreferraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referral_id', 'referralCode', 'agency_id', 'lab_id', 'number', 'year'], 'required'],
            [['referral_id', 'agency_id', 'lab_id', 'number', 'year'], 'integer'],
            [['created_at'], 'safe'],
            [['referralCode'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referral_id' => 'Referral ID',
            'referralCode' => 'Referral Code',
            'agency_id' => 'Agency ID',
            'lab_id' => 'Lab ID',
            'number' => 'Number',
            'year' => 'Year',
            'created_at' => 'Created At',
        ];
    }
}
