<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_referralcode".
 *
 * @property int $referralcode_id
 * @property int $referral_id
 * @property string $referral_code
 * @property int $agency_id
 * @property int $lab_id
 * @property int $number
 * @property int $year
 * @property string $created_date
 *
 * @property Lab $lab
 */
class Referralcode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_referralcode';
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
            [['referral_id', 'referral_code', 'agency_id', 'lab_id', 'number', 'year', 'created_date'], 'required'],
            [['referral_id', 'agency_id', 'lab_id', 'number', 'year'], 'integer'],
            [['created_date'], 'safe'],
            [['referral_code'], 'string', 'max' => 50],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'referralcode_id' => 'Referralcode ID',
            'referral_id' => 'Referral ID',
            'referral_code' => 'Referral Code',
            'agency_id' => 'Agency ID',
            'lab_id' => 'Lab ID',
            'number' => 'Number',
            'year' => 'Year',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }
}
