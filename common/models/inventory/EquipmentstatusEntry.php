<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_equipmentstatus_entry".
 *
 * @property integer $equipmentstatusentry_id
 * @property integer $equipmentstatus_id
 * @property integer $inventory_transactions_id
 *
 * @property Equipmentstatus $equipmentstatus
 * @property InventoryEntries $inventoryTransactions
 */
class EquipmentstatusEntry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_equipmentstatus_entry';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('inventorydb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equipmentstatus_id', 'inventory_transactions_id'], 'required'],
            [['equipmentstatus_id', 'inventory_transactions_id'], 'integer'],
            [['equipmentstatus_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipmentstatus::className(), 'targetAttribute' => ['equipmentstatus_id' => 'equipmentstatus_id']],
            [['inventory_transactions_id'], 'exist', 'skipOnError' => true, 'targetClass' => InventoryEntries::className(), 'targetAttribute' => ['inventory_transactions_id' => 'inventory_transactions_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'equipmentstatusentry_id' => 'Equipmentstatusentry ID',
            'equipmentstatus_id' => 'Equipmentstatus ID',
            'inventory_transactions_id' => 'Inventory Transactions ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentstatus()
    {
        return $this->hasOne(Equipmentstatus::className(), ['equipmentstatus_id' => 'equipmentstatus_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryTransactions()
    {
        return $this->hasOne(InventoryEntries::className(), ['inventory_transactions_id' => 'inventory_transactions_id']);
    }
}
