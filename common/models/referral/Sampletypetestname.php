<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_sampletypetestname".
 *
 * @property int $sampletypetestname_id
 * @property int $sampletype_id
 * @property int $testname_id
 * @property string $added_by
 * @property string $date_added
 *
 * @property Sampletype $sampletype
 * @property Testname $testname
 */
class Sampletypetestname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sampletypetestname';
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
            [['sampletype_id', 'testname_id', 'added_by'], 'required'],
            [['sampletype_id', 'testname_id'], 'integer'],
            [['date_added'], 'safe'],
            [['added_by'], 'string', 'max' => 10],
            [['sampletype_id', 'testname_id'], 'unique', 'targetAttribute' => ['sampletype_id', 'testname_id']],
            [['sampletype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sampletype::className(), 'targetAttribute' => ['sampletype_id' => 'sampletype_id']],
            [['testname_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testname::className(), 'targetAttribute' => ['testname_id' => 'testname_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sampletypetestname_id' => 'Sampletypetestname ID',
            'sampletype_id' => 'Sampletype ID',
            'testname_id' => 'Testname ID',
            'added_by' => 'Added By',
            'date_added' => 'Date Added',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletype()
    {
        return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sampletype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestname()
    {
        return $this->hasOne(Testname::className(), ['testname_id' => 'testname_id']);
    }
}
