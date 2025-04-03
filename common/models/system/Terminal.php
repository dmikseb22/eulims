<?php

namespace common\models\system;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tbl_terminal".
 *
 * @property int $terminal_id
 * @property string $terminal_name
 * @property string $mac_address
 * @property int $is_cashier
 * @property int $created_at
 * @property int $updated_at
 */
class Terminal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_terminal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['terminal_name', 'mac_address'], 'required'],
            [['is_cashier', 'created_at', 'updated_at'], 'integer'],
            [['terminal_name'], 'string', 'max' => 100],
            [['mac_address'], 'string', 'max' => 50],
            [['mac_address'], 'unique'],
            [['terminal_name'], 'unique'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'terminal_id' => 'Terminal ID',
            'terminal_name' => 'Terminal Name',
            'mac_address' => 'Mac Address',
            'is_cashier' => 'Is Cashier',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
