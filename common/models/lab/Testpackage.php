<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_test_package".
 *
 * @property int $testpackage_id
 * @property string $package_name
 * @property int $lab_sampletype_id
 * @property int $package_rate
 * @property int $testname_methods
 * @property int $added_by
 */
class TestPackage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_test_package';
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
            [['package_name', 'lab_sampletype_id', 'package_rate', 'testname_methods', 'added_by'], 'required'],
            [['lab_sampletype_id', 'package_rate', 'testname_methods', 'added_by'], 'integer'],
            [['package_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testpackage_id' => 'Testpackage ID',
            'package_name' => 'Name',
            'lab_sampletype_id' => 'Sample Type',
            'package_rate' => 'Rate',
            'testname_methods' => 'Tests',
            'added_by' => 'Added By',
        ];
    }

    // public function getSampletype()
    // {
    //     return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sampletype_id']);
    // }

}
