<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_referral".
 *
 * @property int $referral_id
 * @property string $referral_code
 * @property string $referral_date_time
 * @property int $receiving_agency_id
 * @property int $testing_agency_id
 * @property int $lab_id
 * @property string $sample_received_date
 * @property int $customer_id
 * @property int $payment_type_id
 * @property int $modeofrelease_id
 * @property int $purpose_id
 * @property int $discount_id
 * @property string $discount_amt
 * @property string $total_fee
 * @property string $report_due
 * @property string $conforme
 * @property int $receiving_user_id
 * @property string $cro_receiving
 * @property int $testing_user_id
 * @property string $cro_testing
 * @property int $bid
 * @property int $cancelled
 * @property string $create_time
 * @property string $update_time
 *
 * @property Attachment[] $attachments
 * @property Bid[] $bs
 * @property Cancelledreferral[] $cancelledreferrals
 * @property Paymenttype $paymentType
 * @property Modeofrelease $modeofrelease
 * @property Lab $lab
 * @property Discount $discount
 * @property Purpose $purpose
 * @property Referraltrackreceiving[] $referraltrackreceivings
 * @property Referraltracktesting[] $referraltracktestings
 * @property Sample[] $samples
 * @property Statuslogs[] $statuslogs
 * @property Statuslogs[] $statuslogs0
 * @property Statuslogs[] $statuslogs1
 */
class Referral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_referral';
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
            [['referral_date_time', 'sample_received_date', 'report_due', 'created_at_local', 'create_time', 'update_time'], 'safe'],
            [['local_request_id', 'receiving_agency_id', 'testing_agency_id', 'lab_id', 'sample_received_date', 'customer_id', 'modeofrelease_id', 'purpose_id', 'report_due', 'conforme', 'receiving_user_id', 'cro_receiving', 'create_time'], 'required'],
            [['local_request_id', 'receiving_agency_id', 'testing_agency_id', 'lab_id', 'customer_id', 'payment_type_id', 'modeofrelease_id', 'purpose_id', 'discount_id', 'receiving_user_id', 'testing_user_id', 'bid', 'cancelled'], 'integer'],
            [['discount_rate', 'total_fee'], 'number'],
            [['referral_code'], 'string', 'max' => 50],
            [['conforme', 'cro_receiving', 'cro_testing'], 'string', 'max' => 100],
            [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paymenttype::className(), 'targetAttribute' => ['payment_type_id' => 'payment_type_id']],
            [['modeofrelease_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modeofrelease::className(), 'targetAttribute' => ['modeofrelease_id' => 'modeofrelease_id']],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discount_id' => 'discount_id']],
            [['purpose_id'], 'exist', 'skipOnError' => true, 'targetClass' => Purpose::className(), 'targetAttribute' => ['purpose_id' => 'purpose_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'referral_id' => 'Referral ID',
            'referral_code' => 'Referral Code',
            'referral_date_time' => 'Referral Date Time',
            'receiving_agency_id' => 'Receiving Agency ID',
            'testing_agency_id' => 'Testing Agency ID',
            'lab_id' => 'Lab ID',
            'sample_received_date' => 'Sample Received Date',
            'customer_id' => 'Customer ID',
            'payment_type_id' => 'Payment Type ID',
            'modeofrelease_id' => 'Modeofrelease ID',
            'purpose_id' => 'Purpose ID',
            'discount_id' => 'Discount ID',
            'discount_amt' => 'Discount Amt',
            'total_fee' => 'Total Fee',
            'report_due' => 'Report Due',
            'conforme' => 'Conforme',
            'receiving_user_id' => 'Receiving User ID',
            'cro_receiving' => 'CRO Receiving',
            'testing_user_id' => 'Testing User ID',
            'cro_testing' => 'CRO Testing',
            'bid' => 'Bid',
            'cancelled' => 'Cancelled',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBs()
    {
        return $this->hasMany(Bid::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCancelledreferrals()
    {
        return $this->hasMany(Cancelledreferral::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentType()
    {
        return $this->hasOne(Paymenttype::className(), ['payment_type_id' => 'payment_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModeofrelease()
    {
        return $this->hasOne(Modeofrelease::className(), ['modeofrelease_id' => 'modeofrelease_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(Discount::className(), ['discount_id' => 'discount_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurpose()
    {
        return $this->hasOne(Purpose::className(), ['purpose_id' => 'purpose_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferraltrackreceivings()
    {
        return $this->hasMany(Referraltrackreceiving::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferraltracktestings()
    {
        return $this->hasMany(Referraltracktesting::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSamples()
    {
        return $this->hasMany(Sample::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatuslogs()
    {
        return $this->hasMany(Statuslogs::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatuslogs0()
    {
        return $this->hasMany(Statuslogs::className(), ['referral_id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatuslogs1()
    {
        return $this->hasMany(Statuslogs::className(), ['referral_id' => 'referral_id']);
    }
}
