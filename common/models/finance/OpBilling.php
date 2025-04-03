<?php

namespace common\models\finance;

use Yii;
use yii\db\ActiveRecord;
use common\models\finance\Billing;
/**
 * This is the model class for table "tbl_op_billing".
 *
 * @property int $op_billing_id
 * @property int $orderofpayment_id
 * @property int $billing_id
 * @property int $created_at
 *
 * @property Orderofpayment $orderofpayment
 * @property Billing $billing
 */
class OpBilling extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_op_billing';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('financedb');
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                 'class' => 'yii\behaviors\TimestampBehavior',
                 'attributes' => [
                     ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                 ],
             ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderofpayment_id', 'billing_id'], 'required'],
            [['orderofpayment_id', 'billing_id', 'created_at'], 'integer'],
            [['orderofpayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Op::className(), 'targetAttribute' => ['orderofpayment_id' => 'orderofpayment_id']],
            [['billing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Billing::className(), 'targetAttribute' => ['billing_id' => 'billing_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'op_billing_id' => 'Op Billing ID',
            'orderofpayment_id' => 'Orderofpayment ID',
            'billing_id' => 'Billing ID',
            'created_at' => 'Created At',
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
    public function getBilling()
    {
        return $this->hasOne(Billing::className(), ['billing_id' => 'billing_id']);
    }
}
