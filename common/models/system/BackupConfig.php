<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "tbl_backup_config".
 *
 * @property int $backup_config_id
 * @property string $mysqldump_path
 * @property string $Description
 */
class BackupConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_backup_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mysqldump_path'], 'required'],
            [['Description'], 'string'],
            [['mysqldump_path'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'backup_config_id' => 'Backup Config ID',
            'mysqldump_path' => 'Mysqldump Path',
            'Description' => 'Description',
        ];
    }
}
