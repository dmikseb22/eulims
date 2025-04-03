<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_sample".
 *
 * @property int $sample_id
 * @property int $rstl_id
 * @property int $pstcsample_id
 * @property int $package_id
 * @property string $package_rate
 * @property int $testcategory_id
 * @property int $sample_type_id
 * @property string $sample_code
 * @property string $samplename
 * @property string $description
 * @property string $sampling_date
 * @property string $remarks
 * @property int $request_id
 * @property int $sample_month
 * @property int $sample_year
 * @property int $active
 * @property int $completed
 *
 * @property Analysis[] $analyses
 * @property Sampletype $sampleType
 * @property Request $request
 * @property Packagelist $package
 * @property Testcategory $testcategory
 * @property TestreportSample[] $testreportSamples
 */
class Restore_sample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sample';
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
            //[['rstl_id', 'testcategory_id', 'sample_type_id', 'samplename', 'description', 'sampling_date', 'request_id', 'sample_month', 'sample_year'], 'required'],
            // [['rstl_id', 'sampletype_id', 'samplename', 'description', 'sampling_date', 'request_id', 'sample_month', 'sample_year'], 'required'],
            // [['rstl_id', 'pstcsample_id', 'package_id', 'testcategory_id', 'sampletype_id', 'request_id', 'sample_month', 'sample_year', 'active', 'completed'], 'integer'],
            // [['package_rate'], 'number'],
            // [['description'], 'string'],
            // [['sampling_date'], 'safe'],
            // [['sample_code'], 'string', 'max' => 20],
            // [['samplename'], 'string', 'max' => 50],
            // [['remarks'], 'string', 'max' => 150],
            // [['sampletype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sampletype::className(), 'targetAttribute' => ['sampletype_id' => 'sampletype_id']],
            // [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['request_id' => 'request_id']],
            // [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packagelist::className(), 'targetAttribute' => ['package_id' => 'package_id']],
            // [['testcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testcategory::className(), 'targetAttribute' => ['testcategory_id' => 'testcategory_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sample_id' => 'Sample ID',
            'rstl_id' => 'Rstl ID',
            'pstcsample_id' => 'Pstcsample ID',
            'package_id' => 'Package ID',
            'package_rate' => 'Package Rate',
            'testcategory_id' => 'Test Category',
            'sampletype_id' => 'Sample Type',
            'sample_code' => 'Sample Code',
            'samplename' => 'Sample Name',
            'description' => 'Description',
            'sampling_date' => 'Sampling Date',
            'remarks' => 'Remarks',
            'request_id' => 'Request Reference Number',
            'sample_month' => 'Sample Month',
            'sample_year' => 'Sample Year',
            'active' => 'Active',
            'completed' => 'Completed',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalyses()
    {
        return $this->hasMany(Analysis::className(), ['sample_id' => 'sample_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletype()
    {
        //return $this->hasOne(Sampletype::className(), ['sample_type_id' => 'sample_type_id']);
        return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sampletype_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['request_id' => 'request_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Packagelist::className(), ['package_id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestcategory()
    {
        return $this->hasOne(Testcategory::className(), ['testcategory_id' => 'testcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestreportSamples()
    {
        return $this->hasMany(TestreportSample::className(), ['sample_id' => 'sample_id']);
    }
}
