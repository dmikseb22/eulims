<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_statuslogs".
 *
 * @property int $statuslogs_id
 * @property int $referral_id
 * @property int $referralstatus_id
 * @property string $date
 * @property string $remarks
 *
 * @property Referral $referral
 * @property Referral $referral0
 * @property Referral $referral1
 * @property Referralstatus $referralstatus
 */
class Statuslogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_statuslogs';
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
            [['referral_id', 'referralstatus_id'], 'required'],
            [['referral_id', 'referralstatus_id'], 'integer'],
            [['date'], 'safe'],
            [['remarks'], 'string', 'max' => 150],
            [['referral_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_id' => 'referral_id']],
            [['referral_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_id' => 'referral_id']],
            [['referral_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_id' => 'referral_id']],
            [['referralstatus_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referralstatus::className(), 'targetAttribute' => ['referralstatus_id' => 'referralstatus_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'statuslogs_id' => 'Statuslogs ID',
            'referral_id' => 'Referral ID',
            'referralstatus_id' => 'Referralstatus ID',
            'date' => 'Date',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferral()
    {
        return $this->hasOne(Referral::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferral0()
    {
        return $this->hasOne(Referral::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferral1()
    {
        return $this->hasOne(Referral::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferralstatus()
    {
        return $this->hasOne(Referralstatus::className(), ['referralstatus_id' => 'referralstatus_id']);
    }
}
