<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_testname_method".
 *
 * @property int $testname_method_id
 * @property int $testname_id
 * @property int $methodreference_id
 * @property string $added_by
 * @property string $create_time
 * @property string $update_time
 *
 * @property Testname $testname
 * @property Methodreference $methodreference
 */
class Testnamemethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_testname_method';
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
            [['testname_id', 'methodreference_id', 'added_by', 'create_time'], 'required'],
            [['testname_id', 'methodreference_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['added_by'], 'string', 'max' => 50],
            [['testname_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testname::className(), 'targetAttribute' => ['testname_id' => 'testname_id']],
            [['methodreference_id'], 'exist', 'skipOnError' => true, 'targetClass' => Methodreference::className(), 'targetAttribute' => ['methodreference_id' => 'methodreference_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testname_method_id' => 'Testname Method ID',
            'lab_id' => 'Lab ID',
            'sampletype_id' => 'Sampletype ID',
            'methodreference_id' => 'Methodreference ID',
            'added_by' => 'Added By',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestname()
    {
        return $this->hasOne(Testname::className(), ['testname_id' => 'testname_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMethodreference()
    {
        return $this->hasOne(Methodreference::className(), ['methodreference_id' => 'methodreference_id']);
    }

    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }

     public function getSampletype()
    {
        return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sampletype_id']);
    }
}
