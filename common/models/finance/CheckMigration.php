<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_check_migration".
 *
 * @property int $check_id
 * @property int $receipt_id
 * @property string $bank
 * @property string $checknumber
 * @property string $checkdate
 * @property double $amount
 * @property int $local_check_id
 */
class CheckMigration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_check_migration';
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
            [['receipt_id', 'local_check_id'], 'integer'],
            [['checkdate'], 'safe'],
            [['amount'], 'number'],
            [['bank', 'checknumber'], 'string', 'max' => 25],
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
            'checknumber' => 'Checknumber',
            'checkdate' => 'Checkdate',
            'amount' => 'Amount',
            'local_check_id' => 'Local Check ID',
            'local_receipt_id' => 'Local Receipt ID',
        ];
    }
}
