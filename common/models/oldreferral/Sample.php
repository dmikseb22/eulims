<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "sample".
 *
 * @property int $id
 * @property int $referral_id
 * @property int $sampleType_id
 * @property string $barcode
 * @property string $sampleName
 * @property string $sampleCode
 * @property string $description
 * @property int $status_id
 * @property string $create_time
 * @property string $update_time
 */
class Sample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sample';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('oldreferraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referral_id', 'sampleType_id', 'barcode', 'sampleName', 'sampleCode', 'description', 'status_id', 'create_time'], 'required'],
            [['referral_id', 'sampleType_id', 'status_id'], 'integer'],
            [['description'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['barcode'], 'string', 'max' => 50],
            [['sampleName'], 'string', 'max' => 100],
            [['sampleCode'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referral_id' => 'Referral ID',
            'sampleType_id' => 'Sample Type ID',
            'barcode' => 'Barcode',
            'sampleName' => 'Sample Name',
            'sampleCode' => 'Sample Code',
            'description' => 'Description',
            'status_id' => 'Status ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    public function beforeSave($insert) {

        if ($insert) {

             $this->create_time = date('Y-m-d H:i:s'); 
             $this->update_time = date('Y-m-d H:i:s');  

        }

        return parent::beforeSave($insert);

    }


        /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalyses()
    {
        return $this->hasMany(Analysis::className(), ['sample_id' => 'id']);
    }
}
