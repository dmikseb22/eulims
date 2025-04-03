<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_inventory_status".
 *
 * @property integer $inventory_status_id
 * @property string $inventory_status
 *
 * @property InventoryWithdrawal[] $inventoryWithdrawals
 */
class InventoryStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_inventory_status';
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
            [['inventory_status'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'inventory_status_id' => 'Inventory Status ID',
            'inventory_status' => 'Inventory Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryWithdrawals()
    {
        return $this->hasMany(InventoryWithdrawal::className(), ['inventory_status_id' => 'inventory_status_id']);
    }
}
