<?php

namespace common\models\finance;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\finance\Customertransaction;
use common\models\lab\Customer;
use yii\db\Expression;

/**
 * This is the model class for table "tbl_customerwallet".
 *
 * @property int $customerwallet_id
 * @property int $rstl_id
 * @property string $date
 * @property string $last_update
 * @property string $balance
 * @property int $customer_id
 *
 * @property Customertransaction[] $customertransactions
 */
class Customerwallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_customerwallet';
    }
 
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => 'last_update',
                'value' => new Expression('NOW()'),
            ],
        ];
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
            [['balance', 'customer_id', 'rstl_id'], 'required'],
            [['date', 'last_update'], 'safe'],
            [['balance'], 'number'],
            [['customer_id'], 'integer'],
            [['customer_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customerwallet_id' => 'Customerwallet ID',
            'rstl_id' => 'Rstl',
            'date' => 'Date',
            'last_update' => 'Last Update',
            'balance' => 'Balance',
            'customer_id' => 'Customer Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomertransactions()
    {
        return $this->hasMany(Customertransaction::className(), ['customerwallet_id' => 'customerwallet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }
}
