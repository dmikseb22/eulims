<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_receipt_status".
 *
 * @property int $receipt_status_id
 * @property string $receipt_status
 */
class ReceiptStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_receipt_status';
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
            [['receipt_status'], 'required'],
            [['receipt_status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'receipt_status_id' => 'Receipt Status ID',
            'receipt_status' => 'Receipt Status',
        ];
    }
}
