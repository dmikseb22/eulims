<?php

namespace common\models\finance;

use Yii;
use common\models\lab\Customer;
/**
 * This is the model class for table "tbl_billing".
 *
 * @property int $billing_id
 * @property int $user_id
 * @property int $customer_id
 * @property string $soa_number
 * @property string $invoice_number
 * @property string $billing_date
 * @property string $due_date
 * @property string $amount
 *
 * @property Customer[] $customer
 * @property OpBilling[] $opBillings
 */
class Billing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_billing';
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
            [['user_id', 'customer_id', 'billing_date', 'due_date'], 'required'],
            [['user_id', 'customer_id'], 'integer'],
            [['billing_date', 'due_date'], 'safe'],
            [['amount'], 'number'],
            ['amount', 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['soa_number','invoice_number'], 'string', 'max' => 100],
           // [['receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Receipt::className(), 'targetAttribute' => ['receipt_id' => 'receipt_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'billing_id' => 'Billing ID',
            'invoice_number' => 'Invoice #', 
            'user_id' => 'User',
            'customer_id' => 'Customer',
            'soa_number' => 'Soa Number',
            'billing_date' => 'Billing Date',
            'due_date' => 'Due Date',
            'amount' => 'Amount',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpBillings()
    {
        return $this->hasMany(OpBilling::className(), ['billing_id' => 'billing_id']);
    }
     public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }
}
