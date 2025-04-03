<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_bookingrequest".
 *
 * @property int $bookingrequest_id
 * @property int $request_id
 * @property int $booking_id
 */
class Bookingrequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bookingrequest';
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
            [['request_id', 'booking_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bookingrequest_id' => 'Bookingrequest ID',
            'request_id' => 'Request ID',
            'booking_id' => 'Booking ID',
        ];
    }
}
