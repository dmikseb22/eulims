<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_deposit".
 *
 * @property int $deposit_id
 * @property int $rstl_id
 * @property int $or_series_id
 * @property int $start_or
 * @property int $end_or
 * @property string $deposit_date
 * @property double $amount
 * @property int $deposit_type_id
 *
 * @property DepositType $depositType
 * @property Orseries $orSeries
 * @property Receipt[] $receipts
 */
class Restore_deposit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_deposit';
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
        return [/*
            [['rstl_id', 'or_series_id', 'start_or', 'end_or', 'deposit_date', 'amount'], 'required'],
            [['rstl_id', 'or_series_id', 'start_or', 'end_or', 'deposit_type_id'], 'integer'],
            [['deposit_date'], 'safe'],
            [['amount'], 'safe'],
            [['deposit_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepositType::className(), 'targetAttribute' => ['deposit_type_id' => 'deposit_type_id']],
            [['or_series_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orseries::className(), 'targetAttribute' => ['or_series_id' => 'or_series_id']],
        */];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'deposit_id' => 'Deposit ID',
            'rstl_id' => 'Rstl ID',
            'or_series_id' => 'Or Series ID',
            'start_or' => 'Start Or',
            'end_or' => 'End Or',
            'deposit_date' => 'Deposit Date',
            'amount' => 'Amount',
            'deposit_type_id' => 'Deposit Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepositType()
    {
        return $this->hasOne(DepositType::className(), ['deposit_type_id' => 'deposit_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrSeries()
    {
        return $this->hasOne(Orseries::className(), ['or_series_id' => 'or_series_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['deposit_id' => 'deposit_id']);
    }
}
