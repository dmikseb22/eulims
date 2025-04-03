<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_sampletype".
 *
 * @property int $sampletype_id
 * @property string $sample_type
 * @property int $test_category_id
 *
 * @property Labsampletype[] $labsampletypes
 * @property Lab[] $labs
 * @property Sample[] $samples
 * @property Sampletypetestname[] $sampletypetestnames
 * @property Test[] $testnames
 */
class Sampletype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sampletype';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('referraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sample_type', 'test_category_id'], 'required'],
            [['test_category_id'], 'integer'],
            [['sample_type'], 'string', 'max' => 75],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sampletype_id' => 'Sampletype ID',
            'sample_type' => 'Sample Type',
            'test_category_id' => 'Test Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabsampletypes()
    {
        return $this->hasMany(Labsampletype::className(), ['sampletype_id' => 'sampletype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabs()
    {
        return $this->hasMany(Lab::className(), ['lab_id' => 'lab_id'])->viaTable('tbl_labsampletype', ['sampletype_id' => 'sampletype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSamples()
    {
        return $this->hasMany(Sample::className(), ['sample_type_id' => 'sampletype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletypetestnames()
    {
        return $this->hasMany(Sampletypetestname::className(), ['sampletype_id' => 'sampletype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestnames()
    {
        return $this->hasMany(Test::className(), ['test_id' => 'testname_id'])->viaTable('tbl_sampletypetestname', ['sampletype_id' => 'sampletype_id']);
    }
}
