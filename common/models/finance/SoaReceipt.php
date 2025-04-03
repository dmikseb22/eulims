<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_soa_receipt".
 *
 * @property int $soa_receipt_id
 * @property int $soa_id
 * @property int $receipt_id
 *
 * @property Soa $soa
 * @property Receipt $receipt
 */
class SoaReceipt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_soa_receipt';
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
            [['soa_id', 'receipt_id'], 'required'],
            [['soa_id', 'receipt_id'], 'integer'],
            [['soa_id', 'receipt_id'], 'unique', 'targetAttribute' => ['soa_id', 'receipt_id']],
            [['soa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Soa::className(), 'targetAttribute' => ['soa_id' => 'soa_id']],
            [['receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Receipt::className(), 'targetAttribute' => ['receipt_id' => 'receipt_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'soa_receipt_id' => 'Soa Receipt ID',
            'soa_id' => 'Soa ID',
            'receipt_id' => 'Receipt ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoa()
    {
        return $this->hasOne(Soa::className(), ['soa_id' => 'soa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipt()
    {
        return $this->hasOne(Receipt::className(), ['receipt_id' => 'receipt_id']);
    }
}
