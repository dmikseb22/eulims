<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_deposit_migration".
 *
 * @property int $deposit_id
 * @property int $rstl_id
 * @property int $or_series_id
 * @property int $start_or
 * @property int $end_or
 * @property string $deposit_date
 * @property double $amount
 * @property int $deposit_type_id
 * @property int $local_deposit_id
 */
class DepositMigration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_deposit_migration';
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
            [['rstl_id', 'or_series_id', 'start_or', 'end_or', 'deposit_date', 'amount'], 'required'],
            [['rstl_id', 'or_series_id', 'start_or', 'end_or', 'deposit_type_id', 'local_deposit_id'], 'integer'],
            [['deposit_date'], 'safe'],
            [['amount'], 'number'],
        ];
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
            'local_deposit_id' => 'Local Deposit ID',
        ];
    }
}
