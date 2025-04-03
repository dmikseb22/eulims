<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_equipmentstatus".
 *
 * @property integer $equipmentstatus_id
 * @property string $equipmentstatus
 *
 * @property EquipmentstatusEntry[] $equipmentstatusEntries
 */
class Equipmentstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_equipmentstatus';
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
            [['equipmentstatus'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'equipmentstatus_id' => 'Equipmentstatus ID',
            'equipmentstatus' => 'Equipmentstatus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentstatusEntries()
    {
        return $this->hasMany(EquipmentstatusEntry::className(), ['equipmentstatus_id' => 'equipmentstatus_id']);
    }
}
