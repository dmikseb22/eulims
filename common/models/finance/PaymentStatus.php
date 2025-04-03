<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_payment_status".
 *
 * @property int $payment_status_id
 * @property string $payment_status
 *
 * @property Collection[] $collections
 */
class PaymentStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_payment_status';
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
            [['payment_status'], 'required'],
            [['payment_status'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payment_status_id' => 'Payment Status ID',
            'payment_status' => 'Payment Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollections()
    {
        return $this->hasMany(Collection::className(), ['payment_status_id' => 'payment_status_id']);
    }
}
