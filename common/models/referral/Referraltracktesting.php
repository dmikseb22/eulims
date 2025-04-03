<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_referraltracktesting".
 *
 * @property int $referraltracktesting_id
 * @property int $referral_id
 * @property int $testing_agency_id
 * @property int $receiving_agency_id
 * @property string $date_received_courier
 * @property string $analysis_started
 * @property string $analysis_completed
 * @property string $cal_specimen_send_date
 * @property int $courier_id
 * @property string $date_created
 *
 * @property Referral $referral
 * @property Courier $courier
 */
class Referraltracktesting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_referraltracktesting';
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
            [['referral_id', 'testing_agency_id', 'receiving_agency_id', 'date_received_courier', 'courier_id', 'date_created'], 'required'],
            [['referral_id', 'testing_agency_id', 'receiving_agency_id', 'courier_id'], 'integer'],
            [['date_received_courier', 'analysis_started', 'analysis_completed', 'cal_specimen_send_date', 'date_created'], 'safe'],
            [['referral_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_id' => 'referral_id']],
            [['courier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Courier::className(), 'targetAttribute' => ['courier_id' => 'courier_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'referraltracktesting_id' => 'Referraltracktesting ID',
            'referral_id' => 'Referral ID',
            'testing_agency_id' => 'Testing Agency ID',
            'receiving_agency_id' => 'Receiving Agency ID',
            'date_received_courier' => 'Date Received Courier',
            'analysis_started' => 'Analysis Started',
            'analysis_completed' => 'Analysis Completed',
            'cal_specimen_send_date' => 'Cal Specimen Send Date',
            'courier_id' => 'Courier',
            'date_created' => 'Date Created',
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
    public function getCourier()
    {
        return $this->hasOne(Courier::className(), ['courier_id' => 'courier_id']);
    }
}
