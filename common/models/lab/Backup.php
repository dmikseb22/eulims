<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_backup".
 *
 * @property int $backup_id
 * @property string $table_name
 * @property string $status
 * @property string $backup
 */
class Backup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_backup';
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
            [['backup_id', 'table_name', 'status', 'backup'], 'required'],
            [['backup_id'], 'integer'],
            [['table_name', 'status', 'backup'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'backup_id' => 'Backup ID',
            'table_name' => 'Table Name',
            'status' => 'Status',
            'backup' => 'Backup',
        ];
    }
}
