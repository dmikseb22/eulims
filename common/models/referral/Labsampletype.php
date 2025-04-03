<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_labsampletype".
 *
 * @property int $labsampletype_id
 * @property int $lab_id
 * @property int $sampletype_id
 * @property string $date_added
 * @property string $added_by
 *
 * @property Sampletype $sampletype
 * @property Lab $lab
 */
class Labsampletype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_labsampletype';
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
            [['lab_id', 'sampletype_id', 'date_added', 'added_by'], 'required'],
            [['lab_id', 'sampletype_id'], 'integer'],
            [['date_added'], 'safe'],
            [['added_by'], 'string', 'max' => 10],
            [['lab_id', 'sampletype_id'], 'unique', 'targetAttribute' => ['lab_id', 'sampletype_id']],
            [['sampletype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sampletype::className(), 'targetAttribute' => ['sampletype_id' => 'sampletype_id']],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'labsampletype_id' => 'Labsampletype ID',
            'lab_id' => 'Lab ID',
            'sampletype_id' => 'Sampletype ID',
            'date_added' => 'Date Added',
            'added_by' => 'Added By',
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
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }
}
