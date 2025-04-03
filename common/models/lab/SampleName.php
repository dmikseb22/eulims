<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_sample_name".
 *
 * @property int $sample_name_id
 * @property string $sample_name
 * @property string $description
 */
class SampleName extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sample_name';
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
            [['sample_name', 'description'], 'required'],
            [['sample_name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 200],
            [['sample_name', 'description'], 'unique', 'targetAttribute' => ['sample_name', 'description']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sample_name_id' => 'Sample Name ID',
            'sample_name' => 'Sample Name',
            'description' => 'Description',
        ];
    }
}
