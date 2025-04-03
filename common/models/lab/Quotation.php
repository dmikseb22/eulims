<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_quotation".
 *
 * @property int $quotation_id
 * @property int $customer_id
 * @property string $content
 * @property int $status_id
 * @property int $qty
 * @property int $rstl_id
 * @property string $create_time
 */
class Quotation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_quotation';
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
            [['customer_id', 'rstl_id'], 'required'],
            [['customer_id', 'status_id', 'qty', 'rstl_id'], 'integer'],
            [['content'], 'string'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quotation_id' => 'Quotation ID',
            'customer_id' => 'Customer ID',
            'content' => 'Content',
            'status_id' => 'Status ID',
            'qty' => 'Qty',
            'rstl_id' => 'Rstl ID',
            'create_time' => 'Create Time',
        ];
    }
}
