<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "methodreference".
 *
 * @property int $id
 * @property int $testname_id
 * @property string $method
 * @property string $reference
 * @property double $fee
 * @property string $create_time
 * @property string $update_time
 */
class Methodreference extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'methodreference';
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
            [['testname_id', 'method', 'reference', 'fee', 'create_time'], 'required'],
            [['testname_id'], 'integer'],
            [['fee'], 'number'],
            [['create_time', 'update_time'], 'safe'],
            [['method', 'reference'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'testname_id' => 'Testname ID',
            'method' => 'Method',
            'reference' => 'Reference',
            'fee' => 'Fee',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
