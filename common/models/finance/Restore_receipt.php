<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_Restore_receipt".
 *
 * @property int $receipt_id
 * @property int $rstl_id
 * @property int $terminal_id
 * @property int $orderofpayment_id
 * @property int $deposit_type_id
 * @property int $or_series_id
 * @property string $or_number
 * @property string $receiptDate
 * @property int $payment_mode_id
 * @property string $payor
 * @property int $collectiontype_id
 * @property string $total
 * @property int $receipt_status_id
 * @property int $deposit_id
 * @property int $customer_id
 *
 * @property Check[] $checks
 * @property Paymentitem[] $paymentitems
 * @property DepositType $depositType
 * @property Paymentmode $paymentMode
 * @property Collectiontype $collectiontype
 * @property Collection $collection
 * @property Deposit $deposit
 * @property SoaReceipt[] $soaReceipts
 * @property Soa[] $soas
 */
class Restore_receipt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_receipt';
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
        return [/*
            [['rstl_id', 'terminal_id', 'deposit_type_id', 'or_series_id', 'or_number', 'receiptDate', 'payment_mode_id', 'payor', 'collectiontype_id', 'total', 'cancelled'], 'required'],
            [['rstl_id', 'terminal_id', 'orderofpayment_id', 'deposit_type_id', 'or_series_id', 'payment_mode_id', 'collectiontype_id', 'cancelled', 'deposit_id'], 'integer'],
            [['receiptDate'], 'safe'],
            [['total'], 'number'],
            [['or_number'], 'string', 'max' => 50],
            [['payor'], 'string', 'max' => 100],
            [['rstl_id', 'or_number'], 'unique', 'targetAttribute' => ['rstl_id', 'or_number']],
            [['deposit_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepositType::className(), 'targetAttribute' => ['deposit_type_id' => 'deposit_type_id']],
            [['payment_mode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paymentmode::className(), 'targetAttribute' => ['payment_mode_id' => 'payment_mode_id']],
            [['collectiontype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collectiontype::className(), 'targetAttribute' => ['collectiontype_id' => 'collectiontype_id']],
            [['deposit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Deposit::className(), 'targetAttribute' => ['deposit_id' => 'deposit_id']],
        */];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'receipt_id' => 'Receipt ID',
            'rstl_id' => 'Rstl ID',
            'terminal_id' => 'Terminal ID',
            'orderofpayment_id' => 'OrderofPayment ID',
            'deposit_type_id' => 'Deposit Type ID',
            'or_series_id' => 'Or Series ID',
            'or_number' => 'Or Number',
            'receiptDate' => 'Receipt Date',
            'payment_mode_id' => 'Payment Mode ID',
            'payor' => 'Payor',
            'collectiontype_id' => 'Collectiontype ID',
            'total' => 'Total',
            'receipt_status_id' => 'Receipt Status ID',
            'deposit_id' => 'Deposit ID',
            'customer_id' => 'Customer ID', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecks()
    {
        return $this->hasMany(Check::className(), ['receipt_id' => 'receipt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentitems()
    {
        return $this->hasMany(Paymentitem::className(), ['receipt_id' => 'receipt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepositType()
    {
        return $this->hasOne(DepositType::className(), ['deposit_type_id' => 'deposit_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMode()
    {
        return $this->hasOne(Paymentmode::className(), ['payment_mode_id' => 'payment_mode_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectiontype()
    {
        return $this->hasOne(Collectiontype::className(), ['collectiontype_id' => 'collectiontype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOp()
    {
        return $this->hasOne(Op::className(), ['orderofpayment_id' => 'orderofpayment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposit()
    {
        return $this->hasOne(Deposit::className(), ['deposit_id' => 'deposit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoaReceipts()
    {
        return $this->hasMany(SoaReceipt::className(), ['receipt_id' => 'receipt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoas()
    {
        return $this->hasMany(Soa::className(), ['soa_id' => 'soa_id'])->viaTable('tbl_soa_receipt', ['receipt_id' => 'receipt_id']);
    }
}
