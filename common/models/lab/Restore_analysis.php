<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_analysis".
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
 * @property int $cancelled
 * @property int $user_id
 * @property int $testcategory_id
  * @property int $sample_type_id
 *
 * @property Test $test
 * @property Sample $sample
 * @property Request $request
 * @property Test $test0
 * @property Tagging[] $tagging
 */
class Restore_analysis extends \yii\db\ActiveRecord
{
  
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_analysis';
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
            // [['date_analysis', 'rstl_id', 'pstcanalysis_id', 'request_id', 'sample_id', 'sample_code', 'testname', 'method', 'references', 'quantity', 'test_id', 'cancelled'], 'required'],
            // [['date_analysis'], 'safe'],
            // [['rstl_id', 'pstcanalysis_id', 'request_id', 'sample_id', 'quantity', 'test_id', 'cancelled', 'user_id', 'is_package'], 'integer'],
            // [['fee'], 'number'],
            // [['sample_code'], 'string', 'max' => 20],
            // [['testname'], 'string', 'max' => 200],
            // [['method'], 'string', 'max' => 150],
            // [['references'], 'string', 'max' => 500],
         //   [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['test_id' => 'test_id']],
          //  [['sample_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::className(), 'targetAttribute' => ['sample_id' => 'sample_id']],
         //   [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['request_id' => 'request_id']],
      //      [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['test_id' => 'test_id']],
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
            'testname' => 'Test name',
            'method' => 'Method',
            'references' => 'References',
            'quantity' => 'Quantity',
            'fee' => 'Fee',
            'test_id' => 'Test Name',
            'cancelled' => 'Cancelled',
            'user_id' => 'User ID',
            'is_package' => 'Is Package',
            'testcategory_id' => 'Sample Type',
            'sample_type_id' => 'Sample Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['test_id' => 'test_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSample()
    {
        return $this->hasOne(Sample::className(), ['sample_id' => 'sample_id']);
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
    // public function getTest0()
    // {
    //     return $this->hasOne(Test::className(), ['test_id' => 'test_id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagging()
    {
        return $this->hasOne(Tagging::className(), ['analysis_id' => 'analysis_id']);
    }
}
