<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_posted_op".
 *
 * @property int $posted_op_id
 * @property int $orderofpayment_id
 * @property string $posted_datetime
 * @property int $user_id
 * @property string $description
 * @property int $posted
 */
class PostedOp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_posted_op';
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
            [['orderofpayment_id', 'posted_datetime', 'user_id', 'description'], 'required'],
            [['orderofpayment_id', 'user_id', 'posted'], 'integer'],
            [['posted_datetime'], 'safe'],
            [['description'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'posted_op_id' => 'Posted Op ID',
            'orderofpayment_id' => 'Orderofpayment ID',
            'posted_datetime' => 'Posted Datetime',
            'user_id' => 'User ID',
            'description' => 'Description',
            'posted' => 'Posted',
        ];
    }
}
