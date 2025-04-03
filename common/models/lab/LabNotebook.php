<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_lab_notebook".
 *
 * @property int $notebook_id
 * @property resource $notebook_name
 * @property string $description
 * @property string $date_created
 * @property string $file
 * @property int $created_by
 */
class LabNotebook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_lab_notebook';
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
            [['notebook_name', 'file'], 'required'],
            [['description'], 'string'],
            [['date_created'], 'safe'],
            [['created_by'], 'integer'],
            [['notebook_name', 'file'], 'string', 'max' => 100],
            [['file'], 'file', 'extensions'=>'xlsx', 'skipOnEmpty' => true] //experiment only
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'notebook_id' => 'Notebook ID',
            'notebook_name' => 'Notebook Name',
            'description' => 'Description',
            'date_created' => 'Date Created',
            'file' => 'File',
            'created_by' => 'Created By',
        ];
    }
}
