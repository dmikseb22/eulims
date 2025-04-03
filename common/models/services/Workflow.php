<?php

namespace common\models\services;

use Yii;
use common\models\services\Test;
/**
 * This is the model class for table "tbl_workflow".
 *
 * @property int $workflow_id
 * @property int $test_id
 * @property string $method
 * @property string $workflow

 * @property Test $test
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['test_id', 'method', 'workflow'], 'required'],
            [['test_id'], 'integer'],
            [['method'], 'string', 'max' => 40],
            [['workflow'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'workflow_id' => 'Workflow ID',
            'test_id' => 'Test ID',
            'method' => 'Method',
            'workflow' => 'Workflow',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['test_id' => 'test_id']);
    }
}
