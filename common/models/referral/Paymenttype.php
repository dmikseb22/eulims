<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_paymenttype".
 *
 * @property int $payment_type_id
 * @property string $type
 *
 * @property Referral[] $referrals
 */
class Paymenttype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paymenttype';
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
            [['type'], 'required'],
            [['type'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payment_type_id' => 'Payment Type ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrals()
    {
        return $this->hasMany(Referral::className(), ['payment_type_id' => 'payment_type_id']);
    }
}
