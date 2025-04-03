<?php
namespace common\modules\dbmanager\models;
/*
 *
 */

/**
 * Description of BackupModel
 *
 * @author Programmer
 */
class BackupModel extends \yii\base\Model{
    public $backupfiles;
    public $backupdatabase;
    public $database;
    public $extension;
    public $download;
    
    public function rules()
    {
        return [
          [['extension','database'], 'required'],
          [['backupfiles', 'backupdatabase', 'download'], 'integer'],
        ];
    }
}
