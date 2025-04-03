<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_samplecode".
 *
 * @property int $samplecode_id
 * @property int $rstl_id
 * @property string $reference_num
 * @property int $sample_id
 * @property int $lab_id
 * @property int $number
 * @property int $year
 * @property int $source either local or referral sample
 * @property int $cancelled
 */
class Samplecode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_samplecode';
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
            [['rstl_id', 'reference_num', 'sample_id', 'lab_id', 'number', 'year'], 'required'],
            [['rstl_id', 'sample_id', 'lab_id', 'number', 'year', 'source', 'cancelled'], 'integer'],
            [['reference_num'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'samplecode_id' => 'Samplecode ID',
            'rstl_id' => 'Rstl ID',
            'reference_num' => 'Reference Num',
            'sample_id' => 'Sample ID',
            'lab_id' => 'Lab ID',
            'number' => 'Number',
            'year' => 'Year',
            'source' => 'Source',
            'cancelled' => 'Cancelled',
        ];
    }
}
