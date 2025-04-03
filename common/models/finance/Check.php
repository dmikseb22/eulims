<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_check".
 *
 * @property int $check_id
 * @property int $receipt_id 
 * @property string $bank
 * @property string $checknumber
 * @property string $checkdate
 * @property double $amount
 *
 * @property Receipt $receipt
 */
class Check extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_check';
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
            [['receipt_id', 'bank', 'checknumber', 'checkdate', 'amount'], 'required'],
            [['receipt_id'], 'integer'],
            [['checkdate'], 'safe'],
            [['amount'], 'number'],
            [['bank', 'checknumber'], 'string', 'max' => 25],
            [['receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Receipt::className(), 'targetAttribute' => ['receipt_id' => 'receipt_id']], 
             [$this->attributes(), 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'check_id' => 'Check ID',
            'receipt_id' => 'Receipt ID',
            'bank' => 'Bank',
            'checknumber' => 'Check Number',
            'checkdate' => 'Check Date',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipt()
    {
        return $this->hasOne(Receipt::className(), ['receipt_id' => 'receipt_id']);
    }
}
