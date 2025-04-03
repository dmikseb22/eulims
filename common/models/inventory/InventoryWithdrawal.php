<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_inventory_withdrawal".
 *
 * @property int $inventory_withdrawal_id
 * @property int $created_by
 * @property string $withdrawal_datetime
 * @property int $lab_id
 * @property int $total_qty
 * @property string $total_cost
 * @property string $remarks
 *
 * @property InventoryWithdrawaldetails[] $inventoryWithdrawaldetails
 */
class InventoryWithdrawal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_inventory_withdrawal';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('inventorydb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'withdrawal_datetime'], 'required'],
            [['created_by', 'lab_id', 'total_qty'], 'integer'],
            [['withdrawal_datetime'], 'safe'],
            [['total_cost'], 'number'],
            [['remarks'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'inventory_withdrawal_id' => 'Inventory Withdrawal ID',
            'created_by' => 'Created By',
            'withdrawal_datetime' => 'Withdrawal Datetime',
            'lab_id' => 'Lab ID',
            'total_qty' => 'Total Qty',
            'total_cost' => 'Total Cost',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryWithdrawaldetails()
    {
        return $this->hasMany(InventoryWithdrawaldetails::className(), ['inventory_withdrawal_id' => 'inventory_withdrawal_id']);
    }
}
