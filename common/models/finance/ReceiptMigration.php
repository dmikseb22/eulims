<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_receipt_migration".
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
 * @property int $cancelled
 * @property int $deposit_id
 * @property int $customer_id
 * @property int $local_receipt_id
 * @property string $oldColumn_check_money_number
 * @property string $oldColumn_bank
 * @property string $oldColumn_checkdate
 * @property int $local_deposit_id
 * @property int $local_deposit_type_id
 * @property int $local_collection_id
 * @property int $local_orderofpayment_id
 * @property int $collection_id
 */
class ReceiptMigration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_receipt_migration';
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
            // [['rstl_id', 'terminal_id', 'deposit_type_id', 'or_series_id', 'or_number', 'receiptDate', 'payment_mode_id', 'payor', 'collectiontype_id', 'total', 'cancelled', 'customer_id'], 'required'],
            [['rstl_id'], 'required'],
            [['rstl_id', 'terminal_id', 'orderofpayment_id', 'deposit_type_id', 'or_series_id', 'payment_mode_id', 'collectiontype_id', 'cancelled', 'deposit_id', 'customer_id', 'local_receipt_id', 'local_deposit_id', 'local_deposit_type_id', 'local_collection_id', 'local_orderofpayment_id', 'collection_id'], 'integer'],
            [['receiptDate', 'oldColumn_checkdate'], 'safe'],
            [['total'], 'number'],
            [['or_number', 'oldColumn_check_money_number', 'oldColumn_bank'], 'string', 'max' => 50],
            [['payor'], 'string', 'max' => 100],
            [['rstl_id', 'or_number'], 'unique', 'targetAttribute' => ['rstl_id', 'or_number']],
        ];
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
            'orderofpayment_id' => 'Orderofpayment ID',
            'deposit_type_id' => 'Deposit Type ID',
            'or_series_id' => 'Or Series ID',
            'or_number' => 'Or Number',
            'receiptDate' => 'Receipt Date',
            'payment_mode_id' => 'Payment Mode ID',
            'payor' => 'Payor',
            'collectiontype_id' => 'Collectiontype ID',
            'total' => 'Total',
            'cancelled' => 'Cancelled',
            'deposit_id' => 'Deposit ID',
            'customer_id' => 'Customer ID',
            'local_receipt_id' => 'Local Receipt ID',
            'oldColumn_check_money_number' => 'Old Column Check Money Number',
            'oldColumn_bank' => 'Old Column Bank',
            'oldColumn_checkdate' => 'Old Column Checkdate',
            'local_deposit_id' => 'Local Deposit ID',
            'local_deposit_type_id' => 'Local Deposit Type ID',
            'local_collection_id' => 'Local Collection ID',
            'local_orderofpayment_id' => 'Local Orderofpayment ID',
            'collection_id' => 'Collection ID',
        ];
    }
}
