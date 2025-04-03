<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_paymentmode".
 *
 * @property int $payment_mode_id
 * @property string $payment_mode
 *
 * @property Orderofpayment[] $orderofpayments
 * @property Receipt[] $receipts
 */
class Paymentmode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paymentmode';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('financedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_mode'], 'required'],
            [['payment_mode'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payment_mode_id' => 'Payment Mode ID',
            'payment_mode' => 'Payment Mode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderofpayments()
    {
        return $this->hasMany(Orderofpayment::className(), ['payment_mode_id' => 'payment_mode_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['payment_mode_id' => 'payment_mode_id']);
    }
}
