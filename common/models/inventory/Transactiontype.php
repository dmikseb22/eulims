<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_transactiontype".
 *
 * @property integer $transactiontype_id
 * @property string $transactiontype
 *
 * @property InventoryEntries[] $inventoryEntries
 */
class Transactiontype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_transactiontype';
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
            [['transactiontype'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transactiontype_id' => 'Transactiontype ID',
            'transactiontype' => 'Transactiontype',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryEntries()
    {
        return $this->hasMany(InventoryEntries::className(), ['transaction_type_id' => 'transactiontype_id']);
    }
}
