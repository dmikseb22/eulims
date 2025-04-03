<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_paymentitem_migration".
 *
 * @property int $paymentitem_id
 * @property int $rstl_id
 * @property int $request_id
 * @property int $request_type_id
 * @property int $orderofpayment_id
 * @property string $details
 * @property double $amount
 * @property int $cancelled
 * @property int $status
 * @property int $receipt_id
 * @property int $local_paymentitem_id
 * @property int $oldColumn_referral_id
 * @property int $local_receipt_id
 */
class PaymentitemMigration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paymentitem_migration';
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
            [['rstl_id', 'request_id', 'orderofpayment_id', 'details', 'amount'], 'required'],
            [['rstl_id', 'request_id', 'request_type_id', 'orderofpayment_id', 'cancelled', 'status', 'receipt_id', 'local_paymentitem_id', 'oldColumn_referral_id', 'local_receipt_id'], 'integer'],
            [['amount'], 'number'],
            [['details'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paymentitem_id' => 'Paymentitem ID',
            'rstl_id' => 'Rstl ID',
            'request_id' => 'Request ID',
            'request_type_id' => 'Request Type ID',
            'orderofpayment_id' => 'Orderofpayment ID',
            'details' => 'Details',
            'amount' => 'Amount',
            'cancelled' => 'Cancelled',
            'status' => 'Status',
            'receipt_id' => 'Receipt ID',
            'local_paymentitem_id' => 'Local Paymentitem ID',
            'oldColumn_referral_id' => 'Old Column Referral ID',
            'local_receipt_id' => 'Local Receipt ID',
            'local_orderofpayment_id' => 'Local Orderpayment ID',
        ];
    }
}
