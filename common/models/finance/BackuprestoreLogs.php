<?php
namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_backuprestore_logs".
 *
 * @property int $id
 * @property string $activity
 * @property string $transaction_date
 * @property string $data_date
 * @property string $op
 * @property string $paymentitem
 * @property string $receipt
 * @property string $check
 * @property string $deposit
 * @property string $status
 */
class BackuprestoreLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_backuprestore_logs';
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
            [['activity'], 'string', 'max' => 200],
            [['transaction_date'], 'string', 'max' => 100],
            [['data_date', 'op', 'paymentitem', 'receipt', 'check', 'deposit', 'status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity' => 'Activity',
            'transaction_date' => 'Transaction Date',
            'data_date' => 'Data Date',
            'op' => 'Op',
            'paymentitem' => 'Paymentitem',
            'receipt' => 'Receipt',
            'check' => 'Check',
            'deposit' => 'Deposit',
            'status' => 'Status',
        ];
    }
}
