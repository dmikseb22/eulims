<?php

namespace common\models\referral;

use Yii;
use common\models\referral\Referraltracktesting;

/**
 * This is the model class for table "tbl_referraltrackreceiving".
 *
 * @property int $referraltrackreceiving_id
 * @property int $referral_id
 * @property int $receiving_agency_id
 * @property int $testing_agency_id
 * @property string $sample_received_date
 * @property int $courier_id
 * @property string $shipping_date
 * @property string $cal_specimen_received_date
 * @property string $date_created
 *
 * @property Referral $referral
 * @property Courier $courier
 */
class Referraltrackreceiving extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_referraltrackreceiving';
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
            [['referral_id', 'receiving_agency_id', 'testing_agency_id', 'sample_received_date', 'courier_id', 'shipping_date', 'date_created'], 'required'],
            [['referral_id', 'receiving_agency_id', 'testing_agency_id', 'courier_id'], 'integer'],
            [['sample_received_date', 'shipping_date', 'cal_specimen_received_date', 'date_created'], 'safe'],
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
            'referraltrackreceiving_id' => 'Referraltrackreceiving ID',
            'referral_id' => 'Referral ID',
            'receiving_agency_id' => 'Receiving Agency ID',
            'testing_agency_id' => 'Testing Agency ID',
            'sample_received_date' => 'Sample Received Date',
            'courier_id' => 'Courier',
            'shipping_date' => 'Shipping Date',
            'cal_specimen_received_date' => 'Cal Specimen Received Date',
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
    
    public function getReferraltesting()
    {
        return $this->hasOne(Referraltracktesting::className(), ['referral_id' => 'referral_id']);
    }
}
