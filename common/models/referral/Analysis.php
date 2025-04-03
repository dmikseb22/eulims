<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_analysis".
 *
 * @property int $analysis_id
 * @property string $date_analysis
 * @property int $agency_id
 * @property int $pstcanalysis_id
 * @property int $sample_id
 * @property int $package_id
 * @property int $testname_id
 * @property int $methodreference_id
 * @property string $analysis_fee
 * @property int $cancelled
 * @property int $status
 * @property int $is_package_name
 * @property int $type_fee_id
 * @property int $local_analysis_id
 * @property int $local_sample_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Sample $sample
 * @property Methodreference $methodreference
 * @property Testname $testname
 */
class Analysis extends \yii\db\ActiveRecord
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
        return Yii::$app->get('referraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_analysis', 'agency_id', 'sample_id', 'testname_id', 'methodreference_id', 'cancelled', 'status', 'local_analysis_id', 'local_sample_id', 'created_at'], 'required'],
            [['date_analysis', 'created_at', 'updated_at'], 'safe'],
            [['agency_id', 'pstcanalysis_id', 'sample_id', 'package_id', 'testname_id', 'methodreference_id', 'cancelled', 'status', 'is_package_name', 'type_fee_id', 'local_analysis_id', 'local_sample_id'], 'integer'],
            [['analysis_fee'], 'number'],
            [['sample_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::className(), 'targetAttribute' => ['sample_id' => 'sample_id']],
            [['methodreference_id'], 'exist', 'skipOnError' => true, 'targetClass' => Methodreference::className(), 'targetAttribute' => ['methodreference_id' => 'methodreference_id']],
            [['testname_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testname::className(), 'targetAttribute' => ['testname_id' => 'testname_id']],
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
            'agency_id' => 'Agency ID',
            'pstcanalysis_id' => 'Pstcanalysis ID',
            'sample_id' => 'Sample ID',
            'package_id' => 'Package ID',
            'testname_id' => 'Testname ID',
            'methodreference_id' => 'Methodreference ID',
            'analysis_fee' => 'Analysis Fee',
            'cancelled' => 'Cancelled',
            'status' => 'Status',
            'is_package_name' => 'Is Package Name',
            'type_fee_id' => 'Type Fee ID',
            'local_analysis_id' => 'Local Analysis ID',
            'local_sample_id' => 'Local Sample ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public function getMethodreference()
    {
        return $this->hasOne(Methodreference::className(), ['methodreference_id' => 'methodreference_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestname()
    {
        return $this->hasOne(Testname::className(), ['testname_id' => 'testname_id']);
    }
}
