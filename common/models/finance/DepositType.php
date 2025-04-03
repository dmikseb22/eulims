<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_deposit_type".
 *
 * @property int $deposit_type_id
 * @property string $deposit_type
 *
 * @property Deposit[] $deposits
 * @property Receipt[] $receipts
 */
class DepositType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_deposit_type';
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
            [['deposit_type'], 'required'],
            [['deposit_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'deposit_type_id' => 'Deposit Type ID',
            'deposit_type' => 'Deposit Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasMany(Deposit::className(), ['deposit_type_id' => 'deposit_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['project_id' => 'deposit_type_id']);
    }
}
