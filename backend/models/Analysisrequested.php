<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_analysisrequested".
 *
 * @property int $analysis_id
 * @property string $sample_description
 * @property string $control_no
 * @property string $analysis
 * @property string $price
 * @property string $total
 * @property int $joborder_id
 * @property string $type
 * @property string $status
 */
class Analysisrequested extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_analysisrequested';
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
            [['analysis_id', 'sample_description', 'control_no', 'analysis', 'price', 'total', 'joborder_id', 'type', 'status'], 'required'],
            [['analysis_id', 'joborder_id'], 'integer'],
            [['sample_description', 'control_no', 'analysis', 'price', 'total', 'type'], 'string', 'max' => 200],
            [['status'], 'string', 'max' => 100],
            [['analysis_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'analysis_id' => 'Analysis ID',
            'sample_description' => 'Sample Description',
            'control_no' => 'Control No',
            'analysis' => 'Analysis',
            'price' => 'Price',
            'total' => 'Total',
            'joborder_id' => 'Joborder ID',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }
}
