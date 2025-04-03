<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_testreport_sample".
 *
 * @property integer $testreport_sample_id
 * @property integer $testreport_id
 * @property integer $sample_id
 *
 * @property Sample $sample
 * @property Testreport $testreport
 */
class TestreportSample extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_testreport_sample';
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
            [['testreport_id', 'sample_id'], 'required'],
            [['testreport_id', 'sample_id'], 'integer'],
            [['sample_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::className(), 'targetAttribute' => ['sample_id' => 'sample_id']],
            [['testreport_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testreport::className(), 'targetAttribute' => ['testreport_id' => 'testreport_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'testreport_sample_id' => 'Testreport Sample ID',
            'testreport_id' => 'Testreport ID',
            'sample_id' => 'Sample ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSample()
    {
        return $this->hasOne(Sample::className(), ['sample_id' => 'sample_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestreport()
    {
        return $this->hasOne(Testreport::className(), ['testreport_id' => 'testreport_id']);
    }
}
