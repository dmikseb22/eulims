<?php

namespace common\models\finance;

use Yii;
use common\models\finance\Op;
/**
 * This is the model class for table "tbl_cancelled_op".
 *
 * @property int $cancelled_op_id
 * @property int $orderofpayment_id
 * @property string $transactionnum
 * @property string $reason
 * @property string $cancel_date
 * @property int $cancelledby
 *
 * @property Orderofpayment $orderofpayment
 */
class CancelledOp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_cancelled_op';
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
            [['orderofpayment_id', 'transactionnum', 'reason', 'cancel_date', 'cancelledby'], 'required'],
            [['orderofpayment_id', 'cancelledby'], 'integer'],
            [['reason'], 'string'],
            [['cancel_date'], 'safe'],
            [['transactionnum'], 'string', 'max' => 100],
            [['orderofpayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Op::className(), 'targetAttribute' => ['orderofpayment_id' => 'orderofpayment_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cancelled_op_id' => 'Cancelled Op ID',
            'orderofpayment_id' => 'Orderofpayment ID',
            'transactionnum' => 'Transactionnum',
            'reason' => 'Reason',
            'cancel_date' => 'Cancel Date',
            'cancelledby' => 'Cancelledby',
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
