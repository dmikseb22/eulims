<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_inventory_withdrawaldetails".
 *
 * @property int $inventory_withdrawaldetails_id
 * @property int $inventory_withdrawal_id
 * @property int $inventory_transactions_id
 * @property int $quantity
 * @property string $price
 * @property int $withdarawal_status_id
 *
 * @property InventoryWithdrawal $inventoryWithdrawal
 * @property InventoryEntries $inventoryTransactions
 */
class InventoryWithdrawaldetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_inventory_withdrawaldetails';
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
            [['inventory_withdrawal_id', 'inventory_transactions_id', 'quantity', 'withdarawal_status_id'], 'required'],
            [['inventory_withdrawal_id', 'inventory_transactions_id', 'quantity', 'withdarawal_status_id'], 'integer'],
            [['price'], 'number'],
            [['inventory_withdrawal_id'], 'exist', 'skipOnError' => true, 'targetClass' => InventoryWithdrawal::className(), 'targetAttribute' => ['inventory_withdrawal_id' => 'inventory_withdrawal_id']],
            [['inventory_transactions_id'], 'exist', 'skipOnError' => true, 'targetClass' => InventoryEntries::className(), 'targetAttribute' => ['inventory_transactions_id' => 'inventory_transactions_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'inventory_withdrawaldetails_id' => 'Inventory Withdrawaldetails ID',
            'inventory_withdrawal_id' => 'Inventory Withdrawal ID',
            'inventory_transactions_id' => 'Inventory Transactions ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'withdarawal_status_id' => 'Withdarawal Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryWithdrawal()
    {
        return $this->hasOne(InventoryWithdrawal::className(), ['inventory_withdrawal_id' => 'inventory_withdrawal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryTransactions()
    {
        return $this->hasOne(InventoryEntries::className(), ['inventory_transactions_id' => 'inventory_transactions_id']);
    }
}
