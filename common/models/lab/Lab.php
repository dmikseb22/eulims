<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_lab".
 *
 * @property integer $lab_id
 * @property string $labname
 * @property string $labcode
 * @property integer $labcount
 * @property string $nextrequestcode
 * @property integer $active
 *
 * @property Initializecode[] $initializecodes
 * @property Request[] $requests
 * @property Requestcode[] $requestcodes
 * @property Test[] $tests
 * @property Testcategory[] $testcategories
 * @property Testreport[] $testreports
 * @property Testreportconfig[] $testreportconfigs
 */
class Lab extends \yii\db\ActiveRecord
{
    public $nextrequestcode;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_lab';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['labname', 'labcode', 'active'], 'required'],
            [['labcount', 'active'], 'integer'],
            [['labname', 'nextrequestcode'], 'string', 'max' => 50],
            [['labcode'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lab_id' => 'Lab ID',
            'labname' => 'Laboratory',
            'labcode' => 'Lab Code',
            'labcount' => 'Labcount',
            'nextrequestcode' => 'Nextrequestcode',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInitializecodes()
    {
        return $this->hasMany(Initializecode::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestcodes()
    {
        return $this->hasMany(Requestcode::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestcategories()
    {
        return $this->hasMany(Testcategory::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestreports()
    {
        return $this->hasMany(Testreport::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestreportconfigs()
    {
        return $this->hasMany(Testreportconfig::className(), ['lab_id' => 'lab_id']);
    }
}
