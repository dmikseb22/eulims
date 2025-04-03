<?php

namespace common\models\services;

use Yii;

/**
 * This is the model class for table "tbl_procedure".
 *
 * @property int $procedure_id
 * @property string $procedure_name
 * @property string $procedure_code
 */
class Procedure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_procedure';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['procedure_name', 'procedure_code'], 'required'],
            [['procedure_name'], 'string', 'max' => 200],
            [['procedure_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'procedure_id' => 'Procedure ID',
            'procedure_name' => 'Procedure Name',
            'procedure_code' => 'Procedure Code',
        ];
    }
}
