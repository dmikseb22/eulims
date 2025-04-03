<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_sampletype".
 *
 * @property int $sampletype_id
 * @property string $type
 * @property int $status_id
 *
 * @property LabSampletype[] $labSampletypes
 * @property SampletypeTestname[] $sampletypeTestnames
 */
class Sampletype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sampletype';
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
          //  [['type'], 'unique'],
            [['type', 'status_id'], 'required'],
            [['status_id'], 'integer'],
            [['type'], 'string', 'max' => 75],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sampletype_id' => 'Sampletype ID',
            'type' => 'Sample Type',
            'status_id' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabSampletypes()
    {
        return $this->hasMany(Labsampletype::className(), ['sampletype_id' => 'sampletype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletypeTestnames()
    {
        return $this->hasMany(SampletypeTestname::className(), ['sampletype_id' => 'sampletype_id']);
    }
}
