<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_pstcanalysis".
 *
 * @property int $pstc_analysis_id
 * @property int $pstc_sample_id
 * @property int $rstl_id
 * @property int $pstc_id
 * @property int $testname_id
 * @property string $testname
 * @property int $package_id
 * @property string $package_name
 * @property int $method_id
 * @property string $method
 * @property string $reference
 * @property string $fee
 * @property int $testcategory_id
 * @property int $sampletype_id
 * @property int $quantity
 * @property int $is_package
 * @property int $is_package_name
 * @property int $analysis_offered
 * @property int $local_analysis_id
 * @property int $local_sample_id
 * @property int $cancelled
 * @property int $testId_old
 * @property int $notoffered_testId_old
 * @property int $package_old
 * @property int $deleted_old
 * @property int $taggingId_old
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Pstcanalysis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_pstcanalysis';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('referraldb');
    }


    public static function primaryKey()
    {
        return ['pstc_analysis_id'];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pstc_sample_id', 'rstl_id', 'pstc_id', 'testname_id', 'testname', 'method_id', 'method', 'reference', 'quantity', 'testId_old', 'package_old', 'deleted_old', 'taggingId_old', 'user_id'], 'required'],
            [['pstc_sample_id', 'rstl_id', 'pstc_id', 'testname_id', 'package_id', 'method_id', 'testcategory_id', 'sampletype_id', 'quantity', 'is_package', 'is_package_name', 'analysis_offered', 'local_analysis_id', 'local_sample_id', 'cancelled', 'testId_old', 'notoffered_testId_old', 'package_old', 'deleted_old', 'taggingId_old', 'user_id'], 'integer'],
            [['fee'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['testname'], 'string', 'max' => 200],
            [['package_name', 'method'], 'string', 'max' => 150],
            [['reference'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pstc_analysis_id' => 'Pstc Analysis ID',
            'pstc_sample_id' => 'Pstc Sample ID',
            'rstl_id' => 'Rstl ID',
            'pstc_id' => 'Pstc ID',
            'testname_id' => 'Testname ID',
            'testname' => 'Testname',
            'package_id' => 'Package ID',
            'package_name' => 'Package Name',
            'method_id' => 'Method ID',
            'method' => 'Method',
            'reference' => 'Reference',
            'fee' => 'Fee',
            'testcategory_id' => 'Testcategory ID',
            'sampletype_id' => 'Sampletype ID',
            'quantity' => 'Quantity',
            'is_package' => 'Is Package',
            'is_package_name' => 'Is Package Name',
            'analysis_offered' => 'Analysis Offered',
            'local_analysis_id' => 'Local Analysis ID',
            'local_sample_id' => 'Local Sample ID',
            'cancelled' => 'Cancelled',
            'testId_old' => 'Test Id Old',
            'notoffered_testId_old' => 'Notoffered Test Id Old',
            'package_old' => 'Package Old',
            'deleted_old' => 'Deleted Old',
            'taggingId_old' => 'Tagging Id Old',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getSample()
    {
        return $this->hasOne(Pstcsample::className(), ['pstc_sample_id' => 'pstc_sample_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTestnames()
    {
        return $this->hasOne(\common\models\lab\Testname::className(), ['testname_id' => 'testname_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMethodrefs()
    {
        return $this->hasOne(\common\models\lab\Methodreference::className(), ['method_reference_id' => 'method_id']);
    }
}
