<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_units".
 *
 * @property int $unitid
 * @property string $unit
 */
class Units extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_units';
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
            [['unit'], 'required'],
            [['unit'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'unitid' => 'Unitid',
            'unit' => 'Unit',
        ];
    }
}
