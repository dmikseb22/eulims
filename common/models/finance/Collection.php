<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_collection".
 *
 * @property int $collection_id
 * @property int $rstl_id
 * @property int $orderofpayment_id
 * @property int $referral_id
 * @property string $nature
 * @property string $amount
 * @property string $wallet_amount
 * @property string $sub_total
 * @property int $payment_status_id
 *
 * @property Customertransaction $customertransaction 
 * @property Orderofpayment $orderofpayment
 * @property PaymentStatus $paymentStatus
 * @property Receipt[] $receipts
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_collection';
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
            [['rstl_id', 'nature'], 'required'],
            [['rstl_id', 'orderofpayment_id', 'referral_id', 'payment_status_id'], 'integer'],
            [['amount', 'wallet_amount', 'sub_total'], 'number'],
            [['nature'], 'string', 'max' => 50],
            [['rstl_id'], 'unique'],
            [['orderofpayment_id'], 'unique'],
            [['orderofpayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Op::className(), 'targetAttribute' => ['orderofpayment_id' => 'orderofpayment_id']],
            [['payment_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentStatus::className(), 'targetAttribute' => ['payment_status_id' => 'payment_status_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'collection_id' => 'Collection ID',
            'rstl_id' => 'Rstl ID',
            'orderofpayment_id' => 'Orderofpayment ID',
            'referral_id' => 'Referral ID',
            'nature' => 'Nature',
            'amount' => 'Amount',
            'wallet_amount' => 'Wallet Amount',
            'sub_total' => 'Sub Total',
            'payment_status_id' => 'Payment Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderofpayment()
    {
        return $this->hasOne(Op::className(), ['orderofpayment_id' => 'orderofpayment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentStatus()
    {
        return $this->hasOne(PaymentStatus::className(), ['payment_status_id' => 'payment_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['collection_id' => 'collection_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
    */
    public function getCustomertransaction() {
        return $this->hasOne(Customertransaction::className(), ['collection_id' => 'collection_id']);
    }

}
