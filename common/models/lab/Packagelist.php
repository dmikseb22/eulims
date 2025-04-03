<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_packagelist".
 *
 * @property int $package_id
 * @property int $rstl_id
 * @property int $lab_id
 * @property int $testcategory_id
 * @property int $sample_type_id
 * @property string $name
 * @property string $rate
 * @property string $tests
 *
 * @property Sample[] $samples
 */
class Packagelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_packagelist';
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
            [['rstl_id', 'lab_id', 'sample_type_id', 'name', 'tests'], 'required'],
            [['rstl_id', 'lab_id', 'testcategory_id', 'sample_type_id'], 'integer'],
            [['rate'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['tests'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'package_id' => 'Package ID',
            'rstl_id' => 'Rstl ID',
            'lab_id' => 'Lab ID',
            'testcategory_id' => 'Test Category',
            'sample_type_id' => 'Sample Type',
            'name' => 'Package',
            'rate' => 'Rate',
            'tests' => 'Tests',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSamples()
    {
        return $this->hasMany(Sample::className(), ['package_id' => 'package_id']);
    }

    public function getTestCategory()
    {
        return $this->hasOne(Testcategory::className(), ['testcategory_id' => 'testcategory_id']);
    }

    public function getSampleType()
    {
        return $this->hasOne(Sampletype::className(), ['sample_type_id' => 'sample_type_id']);
    }

}
