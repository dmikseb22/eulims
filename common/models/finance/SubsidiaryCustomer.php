<?php

namespace common\models\finance;


/**
 * This is the model class for table "tbl_subsidiary_customer".
 *
 * @property int $subsidiary_customer_id
 * @property int $orderofpayment_id
 * @property int $customer_id
 *
 * @property Orderofpayment $orderofpayment
 */
class SubsidiaryCustomer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_subsidiary_customer';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return \Yii::$app->get('financedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderofpayment_id', 'customer_id'], 'required'],
            [['orderofpayment_id', 'customer_id'], 'integer'],
            [['orderofpayment_id', 'customer_id'], 'unique', 'targetAttribute' => ['orderofpayment_id', 'customer_id']],
            [['orderofpayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Op::className(), 'targetAttribute' => ['orderofpayment_id' => 'orderofpayment_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'subsidiary_customer_id' => 'Subsidiary Customer ID',
            'orderofpayment_id' => 'Orderofpayment ID',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderofpayment()
    {
        return $this->hasOne(Op::className(), ['orderofpayment_id' => 'orderofpayment_id']);
    }
}
