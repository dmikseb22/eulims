<?php

namespace common\models\finance;

use Yii;
use common\models\lab\Customer;
/**
 * This is the model class for table "tbl_client".
 *
 * @property int $client_id
 * @property string $account_number
 * @property int $customer_id
 * @property string $company_name
 * 
 * @property string $signature_date
 * @property int $signed
 * @property int $active
 * @property Customer $customer
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_client';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('financedb');
    }
    
    public function beforeSave($insert) {
        if ($insert) {
            $cust_id= $this->customer_id;
            $AccNum= str_pad($GLOBALS['rstl_id'], 3, '0',STR_PAD_LEFT).'-'. str_pad($cust_id,6,'0',STR_PAD_LEFT);
            $this->account_number=$AccNum;
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'signature_date', 'signed', 'active'], 'required'],
            [['customer_id', 'signed', 'active'], 'integer'],
            [['signature_date'], 'safe'],
            [['account_number'], 'string', 'max' => 50],
            [['company_name'], 'string', 'max' => 100],
            ['customer_id', 'unique', 'targetAttribute' => ['customer_id'], 'message' => 'The Customer already Existed.'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client',
            'account_number' => 'Account Number',
            'customer_id' => 'Customer',
            'company_name' => 'Company Name',
            'signature_date' => 'Signature Date',
            'signed' => 'Signed',
            'active' => 'Active',
        ];
    }
     public function getCustomer(){
        return $this->hasOne(Customer::className(), ['customer_id'=>'customer_id']);
    }
}
