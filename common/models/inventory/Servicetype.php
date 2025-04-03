<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_servicetype".
 *
 * @property integer $servicetype_id
 * @property string $servicetype
 *
 * @property Equipmentservice[] $equipmentservices
 */
class Servicetype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_servicetype';
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
            [['servicetype'], 'required'],
            [['servicetype'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'servicetype_id' => 'Servicetype ID',
            'servicetype' => 'Servicetype',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentservices()
    {
        return $this->hasMany(Equipmentservice::className(), ['servicetype_id' => 'servicetype_id']);
    }
}
