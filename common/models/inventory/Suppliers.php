<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_suppliers".
 *
 * @property integer $suppliers_id
 * @property string $suppliers
 * @property string $description
 * @property string $address
 * @property string $contact_person
 * @property string $phone_number
 * @property string $fax_number
 * @property string $email
 *
 * @property InventoryEntries[] $inventoryEntries
 */
class Suppliers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_suppliers';
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
            [['suppliers', 'address', 'contact_person', 'phone_number', 'fax_number', 'email'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 200],
            [['email'],'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'suppliers_id' => 'Suppliers ID',
            'suppliers' => 'Suppliers',
            'description' => 'Description',
            'address' => 'Address',
            'contact_person' => 'Contact Person',
            'phone_number' => 'Phone Number',
            'fax_number' => 'Fax Number',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryEntries()
    {
        return $this->hasMany(InventoryEntries::className(), ['suppliers_id' => 'suppliers_id']);
    }
}
