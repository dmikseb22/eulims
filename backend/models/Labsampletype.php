<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_lab_sampletype".
 *
 * @property int $lab_sampletype_id
 * @property int $lab_id
 * @property int $sampletype_id
 * @property string $effective_date
 * @property string $added_by
 * @property int $testcategory_id
 */
class Labsampletype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_lab_sampletype';
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
            [['lab_id', 'sampletype_id', 'added_by'], 'required'],
            [['lab_id', 'sampletype_id', 'testcategory_id'], 'integer'],
            [['effective_date'], 'safe'],
            [['added_by'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lab_sampletype_id' => 'Lab Sampletype ID',
            'lab_id' => 'Lab ID',
            'sampletype_id' => 'Sampletype ID',
            'effective_date' => 'Effective Date',
            'added_by' => 'Added By',
            'testcategory_id' => 'Testcategory ID',
        ];
    }
}
