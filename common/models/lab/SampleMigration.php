<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_sample_migration".
 *
 * @property int $sample_id
 * @property int $rstl_id
 * @property int $pstcsample_id
 * @property int $package_id
 * @property string $package_rate
 * @property int $testcategory_id
 * @property int $sampletype_id
 * @property string $sample_code
 * @property string $samplename
 * @property string $description
 * @property string $sampling_date
 * @property string $remarks
 * @property int $request_id
 * @property int $sample_month
 * @property int $sample_year
 * @property int $active
 * @property int $sample_old_id
 * @property string $oldColumn_requestId
 * @property double $oldColumn_completed
 * @property string $oldColumn_datedisposal
 * @property string $oldColumn_mannerofdisposal
 * @property int $oldColumn_batch_num
 * @property int $oldColumn_package_count
 */
class SampleMigration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sample_migration';
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
            [['rstl_id', 'sampletype_id', 'samplename', 'description', 'sampling_date', 'request_id', 'sample_month', 'sample_year'], 'required'],
            [['rstl_id', 'pstcsample_id', 'package_id', 'testcategory_id', 'sampletype_id', 'request_id', 'sample_month', 'sample_year', 'active', 'sample_old_id', 'oldColumn_batch_num', 'oldColumn_package_count'], 'integer'],
            [['package_rate', 'oldColumn_completed'], 'number'],
            [['description'], 'string'],
            [['sampling_date', 'oldColumn_datedisposal'], 'safe'],
            [['sample_code'], 'string', 'max' => 20],
            [['samplename', 'oldColumn_requestId'], 'string', 'max' => 50],
            [['remarks'], 'string', 'max' => 150],
            [['oldColumn_mannerofdisposal'], 'string', 'max' => 200],
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
            'testcategory_id' => 'Testcategory ID',
            'sampletype_id' => 'Sampletype ID',
            'sample_code' => 'Sample Code',
            'samplename' => 'Samplename',
            'description' => 'Description',
            'sampling_date' => 'Sampling Date',
            'remarks' => 'Remarks',
            'request_id' => 'Request ID',
            'sample_month' => 'Sample Month',
            'sample_year' => 'Sample Year',
            'active' => 'Active',
            'sample_old_id' => 'Sample Old ID',
            'oldColumn_requestId' => 'Old Column Request ID',
            'oldColumn_completed' => 'Old Column Completed',
            'oldColumn_datedisposal' => 'Old Column Datedisposal',
            'oldColumn_mannerofdisposal' => 'Old Column Mannerofdisposal',
            'oldColumn_batch_num' => 'Old Column Batch Num',
            'oldColumn_package_count' => 'Old Column Package Count',
        ];
    }
}
