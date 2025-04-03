<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_analysis_migration".
 *
 * @property int $analysis_id
 * @property string $date_analysis
 * @property int $rstl_id
 * @property int $pstcanalysis_id
 * @property int $request_id
 * @property int $sample_id
 * @property string $sample_code
 * @property string $testname
 * @property string $method
 * @property string $references
 * @property int $quantity
 * @property string $fee
 * @property int $test_id
 * @property int $testcategory_id
 * @property int $sample_type_id
 * @property int $cancelled
 * @property int $user_id
 * @property int $is_package
 * @property int $type_fee_id
 * @property int $analysis_old_id
 * @property int $oldColumn_taggingId
 * @property string $oldColumn_result
 * @property int $oldColumn_package_count
 * @property string $oldColumn_requestId
 * @property int $oldColumn_deleted
 * @property int $methodreference_id
 * @property int $testname_id
 */
class AnalysisMigration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_analysis_migration';
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
            [['date_analysis', 'rstl_id', 'pstcanalysis_id', 'request_id', 'sample_id', 'sample_code', 'testname', 'method', 'references', 'quantity', 'test_id', 'testcategory_id', 'sample_type_id'], 'required'],
            [['date_analysis'], 'safe'],
            [['rstl_id', 'pstcanalysis_id', 'request_id', 'sample_id', 'quantity', 'test_id', 'testcategory_id', 'sample_type_id', 'cancelled', 'user_id', 'is_package', 'type_fee_id', 'analysis_old_id', 'oldColumn_taggingId', 'oldColumn_package_count', 'oldColumn_deleted', 'methodreference_id', 'testname_id'], 'integer'],
            [['fee'], 'number'],
            [['sample_code'], 'string', 'max' => 20],
            [['testname', 'oldColumn_result'], 'string', 'max' => 200],
            [['method'], 'string', 'max' => 150],
            [['references'], 'string', 'max' => 100],
            [['oldColumn_requestId'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'analysis_id' => 'Analysis ID',
            'date_analysis' => 'Date Analysis',
            'rstl_id' => 'Rstl ID',
            'pstcanalysis_id' => 'Pstcanalysis ID',
            'request_id' => 'Request ID',
            'sample_id' => 'Sample ID',
            'sample_code' => 'Sample Code',
            'testname' => 'Testname',
            'method' => 'Method',
            'references' => 'References',
            'quantity' => 'Quantity',
            'fee' => 'Fee',
            'test_id' => 'Test ID',
            'testcategory_id' => 'Testcategory ID',
            'sample_type_id' => 'Sample Type ID',
            'cancelled' => 'Cancelled',
            'user_id' => 'User ID',
            'is_package' => 'Is Package',
            'type_fee_id' => 'Type Fee ID',
            'analysis_old_id' => 'Analysis Old ID',
            'oldColumn_taggingId' => 'Old Column Tagging ID',
            'oldColumn_result' => 'Old Column Result',
            'oldColumn_package_count' => 'Old Column Package Count',
            'oldColumn_requestId' => 'Old Column Request ID',
            'oldColumn_deleted' => 'Old Column Deleted',
            'methodreference_id' => 'Methodreference ID',
            'testname_id' => 'Testname ID',
        ];
    }
}
