<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_pstcsample".
 *
 * @property int $pstc_sample_id
 * @property int $pstc_request_id
 * @property int $rstl_id
 * @property int $pstc_id
 * @property int $testcategory_id
 * @property int $sampletype_id
 * @property string $sampling_date
 * @property string $sample_name
 * @property string $sample_description
 * @property string $customer_description
 * @property string $sample_code
 * @property int $active
 * @property int $local_sample_id
 * @property int $local_request_id
 * @property int $is_referral
 * @property int $processed_old
 * @property string $created_at
 * @property string $updated_at
 */
class Pstcsample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_pstcsample';
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
        return ['pstc_sample_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pstc_request_id', 'rstl_id', 'pstc_id', 'sample_name', 'sample_description', 'created_at'], 'required'],
            [['pstc_request_id', 'rstl_id', 'pstc_id', 'testcategory_id', 'sampletype_id', 'active', 'local_sample_id', 'local_request_id', 'is_referral', 'processed_old'], 'integer'],
            [['sampling_date', 'created_at', 'updated_at'], 'safe'],
            [['sample_description', 'customer_description'], 'string'],
            [['sample_name'], 'string', 'max' => 100],
            [['sample_code'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pstc_sample_id' => 'Pstc Sample ID',
            'pstc_request_id' => 'Pstc Request ID',
            'rstl_id' => 'Rstl ID',
            'pstc_id' => 'Pstc ID',
            'testcategory_id' => 'Testcategory ID',
            'sampletype_id' => 'Sampletype ID',
            'sampling_date' => 'Sampling Date',
            'sample_name' => 'Sample Name',
            'sample_description' => 'Sample Description',
            'customer_description' => 'Customer Description',
            'sample_code' => 'Sample Code',
            'active' => 'Active',
            'local_sample_id' => 'Local Sample ID',
            'local_request_id' => 'Local Request ID',
            'is_referral' => 'Is Referral',
            'processed_old' => 'Processed Old',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getRequest()
    {
        return $this->hasOne(Pstcrequest::className(), ['pstc_request_id' => 'pstc_request_id']);
    }
	
	/**
    * @return \yii\db\ActiveQuery
    */
    public function getAnalysis()
    {
        return $this->hasMany(Pstcanalysis::className(), ['pstc_sample_id' => 'pstc_sample_id']);
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
    public function getSampletype()
    {
        return $this->hasOne(\api\modules\v1\models\Sampletype::className(), ['sampletype_id' => 'sampletype_id']);
    }
}
