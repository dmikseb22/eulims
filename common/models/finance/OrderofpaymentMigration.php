<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_orderofpayment_migration".
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
 * @property int $receipt_id
 * @property int $payment_status_id
 * @property string $subsidiary_customer_ids
 * @property int $local_orderofpayment_id
 * @property string $oldColumn_customerName
 * @property string $oldColumn_address
 */
class OrderofpaymentMigration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_orderofpayment_migration';
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
            [['rstl_id', 'transactionnum', 'collectiontype_id', 'payment_mode_id', 'order_date', 'customer_id', 'purpose'], 'required'],
            [['rstl_id', 'collectiontype_id', 'payment_mode_id', 'on_account', 'customer_id', 'receipt_id', 'payment_status_id', 'local_orderofpayment_id'], 'integer'],
            [['order_date'], 'safe'],
            [['total_amount'], 'number'],
            [['transactionnum', 'invoice_number'], 'string', 'max' => 100],
            [['purpose', 'oldColumn_address'], 'string', 'max' => 200],
            [['subsidiary_customer_ids'], 'string', 'max' => 50],
            [['oldColumn_customerName'], 'string', 'max' => 250],
            [['receipt_id'], 'unique'],
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
            'receipt_id' => 'Receipt ID',
            'payment_status_id' => 'Payment Status ID',
            'subsidiary_customer_ids' => 'Subsidiary Customer Ids',
            'local_orderofpayment_id' => 'Local Orderofpayment ID',
            'oldColumn_customerName' => 'Old Column Customer Name',
            'oldColumn_address' => 'Old Column Address',
            'local_customer_id'=>'Local Customer ID',
            'is_migrated'=>'is_migrated',
        ];
    }
}
