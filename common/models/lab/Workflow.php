<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_workflow".
 *
 * @property int $workflow_id
 * @property int $testname_method_id
 * @property string $method_id
 * @property string $procedure_name
 * @property string $status
 */
class Workflow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_workflow';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    // public function behaviors()
    // {
    //     return [
    //         'sortable' => [
    //             'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
    //             'query' => self::find(),
    //         ],
    //     ];
    // }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['testname_method_id', 'method_id', 'procedure_name', 'status'], 'required'],
            // [['testname_method_id'], 'integer'],
            // [['method_id'], 'string', 'max' => 40],
            // [['procedure_name'], 'string', 'max' => 100],
            // [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'workflow_id' => 'Workflow ID',
            'testname_method_id' => 'Testname Method ID',
            'method_id' => 'Method ID',
            'procedure_name' => 'Procedure Name',
            'status' => 'Status',
        ];
    }
}
