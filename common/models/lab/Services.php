<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_services".
 *
 * @property int $services_id
 * @property int $rstl_id
 * @property int $lab_id
 * @property int $method_reference_id
 * @property int $sampletype_id
 * @property int $testname_method_id
 */
class Services extends \yii\db\ActiveRecord
{
    public $lab_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_services';
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
            [['rstl_id', 'method_reference_id', 'sampletype_id', 'testname_method_id'], 'required'],
            [['rstl_id', 'method_reference_id', 'sampletype_id', 'testname_method_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'services_id' => 'Services',
            'rstl_id' => 'Rstl',
            'lab_id' => 'Lab',
            'method_reference_id' => 'Method Reference',
            'sampletype_id' => 'Sample Type',
            'testname_method_id' => 'Tests',
        ];
    }
}
