<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_fee".
 *
 * @property integer $fee_id
 * @property string $name
 * @property string $code
 * @property string $unit_cost
 */
class Fee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_fee';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fee_id', 'name', 'code'], 'required'],
            [['fee_id'], 'integer'],
            [['unit_cost'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fee_id' => 'Fee ID',
            'name' => 'Name',
            'code' => 'Code',
            'unit_cost' => 'Unit Cost',
        ];
    }
}
