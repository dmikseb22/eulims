<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_package".
 *
 * @property int $id
 * @property int $rstl_id
 * @property int $testcategory_id
 * @property int $sampletype_id
 * @property string $name
 * @property double $rate
 * @property string $tests
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_package';
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
            [['rstl_id', 'sampletype_id', 'name', 'rate', 'tests'], 'required'],
            [['rstl_id', 'sampletype_id'], 'integer'],
            [['rate'], 'number'],
            [['name'], 'string', 'max' => 40],
          //  [['tests'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rstl_id' => 'Rstl ID',
            'testcategory_id' => 'Testcategory ID',
            'sampletype_id' => 'Sample type',
            'name' => 'Name',
            'rate' => 'Rate',
            'tests' => 'Tests',
        ];
    }

    public function getSampletype()
    {
        return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sampletype_id']);
    }

    // public function getSampletype()
    // {
    //     return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sampletype_id']);
    // }

    public function getTestcategory()
    {
        return $this->hasOne(Testcategory::className(), ['testcategory_id' => 'testcategory_id']);
    }
}
