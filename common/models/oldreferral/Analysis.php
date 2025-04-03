<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "analysis".
 *
 * @property int $id
 * @property int $sample_id
 * @property int $testName_id
 * @property int $methodReference_id
 * @property int $package_id
 * @property int $package
 * @property double $fee
 * @property int $status_id
 * @property string $create_time
 * @property string $update_time
 */
class Analysis extends \yii\db\ActiveRecord
{

    public $sample_ids;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analysis';
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
            [['sample_id', 'testName_id', 'methodReference_id', 'fee', 'status_id', 'create_time'], 'required'],
            [['sample_id', 'testName_id', 'methodReference_id', 'package_id', 'package', 'status_id'], 'integer'],
            [['fee'], 'number'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sample_id' => 'Sample ID',
            'testName_id' => 'Test Name ID',
            'methodReference_id' => 'Method Reference ID',
            'package_id' => 'Package ID',
            'package' => 'Package',
            'fee' => 'Fee',
            'status_id' => 'Status ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    public function beforeSave($insert) {

        if ($insert) {

             $this->create_time = date('Y-m-d H:i:s'); 
             $this->update_time = date('Y-m-d H:i:s');  

        }

        return parent::beforeSave($insert);

    }
}
