<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "testname".
 *
 * @property int $id
 * @property string $testName
 * @property int $status_id
 * @property string $create_time
 * @property string $update_time
 */
class Testname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testname';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('oldreferraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['testName', 'status_id', 'create_time'], 'required'],
            [['status_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['testName'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'testName' => 'Test Name',
            'status_id' => 'Status ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
