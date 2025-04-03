<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "vwbillingop".
 *
 * @property int $orderofpayment_id
 * @property int $rstl_id
 * @property string $transactionnum
 * @property string $invoice_number
 * @property int $collectiontype_id
 * @property int $payment_mode_id
 * @property int $on_account
 * @property string $order_date
 * @property string $total_amount
 * @property int $customer_id
 * @property string $purpose
 * @property int $created_receipt
 * @property int $allow_erratum
 */
class Vwbillingop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vwbillingop';
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
            [['orderofpayment_id', 'rstl_id', 'collectiontype_id', 'payment_mode_id', 'on_account', 'customer_id', 'created_receipt', 'allow_erratum'], 'integer'],
            [['rstl_id', 'transactionnum', 'collectiontype_id', 'payment_mode_id', 'order_date', 'customer_id', 'purpose'], 'required'],
            [['order_date'], 'safe'],
            [['total_amount'], 'number'],
            [['transactionnum', 'invoice_number'], 'string', 'max' => 100],
            [['purpose'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orderofpayment_id' => 'Orderofpayment ID',
            'rstl_id' => 'Rstl ID',
            'transactionnum' => 'Transactionnum',
            'invoice_number' => 'Invoice Number',
            'collectiontype_id' => 'Collectiontype ID',
            'payment_mode_id' => 'Payment Mode ID',
            'on_account' => 'On Account',
            'order_date' => 'Order Date',
            'total_amount' => 'Total Amount',
            'customer_id' => 'Customer ID',
            'purpose' => 'Purpose',
            'created_receipt' => 'Created Receipt',
            'allow_erratum' => 'Allow Erratum',
        ];
    }
}
