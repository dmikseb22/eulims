<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_packagelist".
 *
 * @property int $package_id
 * @property int $lab_id
 * @property int $sampletype_id
 * @property string $name
 * @property string $rate
 * @property string $test_methods
 * @property string $remarks
 * @property int $added_by
 *
 * @property Sample $sampletype
 * @property Lab $lab
 * @property Sample[] $samples
 * @property Sample[] $samples0
 */
class Packagelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_packagelist';
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
            [['lab_id', 'sampletype_id', 'name', 'test_methods'], 'required'],
            [['lab_id', 'sampletype_id', 'added_by'], 'integer'],
            [['rate'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['test_methods', 'remarks'], 'string', 'max' => 200],
            [['sampletype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::className(), 'targetAttribute' => ['sampletype_id' => 'sample_id']],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'package_id' => 'Package ID',
            'lab_id' => 'Lab ID',
            'sampletype_id' => 'Sampletype ID',
            'name' => 'Name',
            'rate' => 'Rate',
            'test_methods' => 'Test Methods',
            'remarks' => 'Remarks',
            'added_by' => 'Added By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletype()
    {
        return $this->hasOne(Sample::className(), ['sample_id' => 'sampletype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSamples()
    {
        return $this->hasMany(Sample::className(), ['package_id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSamples0()
    {
        return $this->hasMany(Sample::className(), ['package_id' => 'package_id']);
    }
}
