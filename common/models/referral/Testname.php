<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_testname".
 *
 * @property int $testname_id
 * @property string $test_name
 * @property int $active
 * @property string $create_time
 * @property string $update_time
 *
 * @property Analysis[] $analyses
 * @property Sampletypetestname[] $sampletypetestnames
 * @property Sampletype[] $sampletypes
 * @property TestnameMethod[] $testnameMethods
 */
class Testname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_testname';
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
            [['test_name', 'create_time'], 'required'],
            [['active'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['test_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testname_id' => 'Testname ID',
            'test_name' => 'Test Name',
            'active' => 'Active',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalyses()
    {
        return $this->hasMany(Analysis::className(), ['testname_id' => 'testname_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletypetestnames()
    {
        return $this->hasMany(Sampletypetestname::className(), ['testname_id' => 'testname_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletypes()
    {
        return $this->hasMany(Sampletype::className(), ['sampletype_id' => 'sampletype_id'])->viaTable('tbl_sampletypetestname', ['testname_id' => 'testname_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestnameMethods()
    {
        return $this->hasMany(Testnamemethod::className(), ['testname_id' => 'testname_id']);
    }
}
