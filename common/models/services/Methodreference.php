<?php

namespace common\models\services;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tbl_methodreference".
 *
 * @property int $method_reference_id
 * @property int $test_id
 * @property string $method
 * @property string $reference
 * @property double $fee
 * @property int $create_time
 * @property int $update_time
 *
 * @property Test $test
 */
class Methodreference extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_methodreference';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }
    
    public function behaviors(){
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function() { 
                    return date('U'); // unix timestamp 
                },
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_id', 'method', 'reference', 'fee'], 'required'],
            [['test_id', 'create_time', 'update_time'], 'integer'],
            [['fee'], 'number'],
            [['method', 'reference'], 'string', 'max' => 200],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['test_id' => 'test_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'method_reference_id' => 'Method Reference ID',
            'test_id' => 'Test ID',
            'method' => 'Method',
            'reference' => 'Reference',
            'fee' => 'Fee',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
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
