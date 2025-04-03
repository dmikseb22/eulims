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
class Bankaccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bankaccount';
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
            [['bankaccount_id', 'bank_name', 'account_number', 'rstl_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bank_name' => 'Bank Name',
            'account_number' => 'Account Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
}
