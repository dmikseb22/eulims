<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_customer_booking".
 *
 * @property int $customer_booking_id
 * @property int $rstl_id
 * @property string $customer_name
 * @property string $tel
 * @property string $email
 * @property int $classification_id
 * @property int $business_nature_id
 * @property string $address
 */
class CustomerBooking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_customer_booking';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rstl_id', 'classification_id', 'business_nature_id'], 'integer'],
            [['customer_name'], 'string', 'max' => 100],
            [['tel', 'email'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 200],
			[['classification_id', 'business_nature_id', 'customer_name', 'email','address','tel'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_booking_id' => 'Customer Booking ID',
            'rstl_id' => 'Rstl ID',
            'customer_name' => 'Customer Name',
            'tel' => 'Tel',
            'email' => 'Email',
            'classification_id' => 'Classification',
            'business_nature_id' => 'Business Nature',
            'address' => 'Address',
        ];
    }
}
