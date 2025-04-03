<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_collection_migration".
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
 * @property int $collection_old_id
 * @property int $oldColumn_request_id
 * @property int $oldColumn_receipt_id
 * @property string $oldColumn_receiptid
 * @property int $oldColumn_cancelled
 * @property int $local_orderofpayment_id
 */
class CollectionMigration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_collection_migration';
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
            [['rstl_id', 'orderofpayment_id', 'referral_id', 'payment_status_id', 'collection_old_id', 'oldColumn_request_id', 'oldColumn_receipt_id', 'oldColumn_cancelled', 'local_orderofpayment_id'], 'integer'],
            [['amount', 'wallet_amount', 'sub_total'], 'number'],
            [['nature', 'oldColumn_receiptid'], 'string', 'max' => 50],
            [['orderofpayment_id'], 'unique'],
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
            'collection_old_id' => 'Collection Old ID',
            'oldColumn_request_id' => 'Old Column Request ID',
            'oldColumn_receipt_id' => 'Old Column Receipt ID',
            'oldColumn_receiptid' => 'Old Column Receiptid',
            'oldColumn_cancelled' => 'Old Column Cancelled',
            'local_orderofpayment_id' => 'Local Orderofpayment ID',
        ];
    }
}
