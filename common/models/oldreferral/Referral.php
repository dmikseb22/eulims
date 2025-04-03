<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "referral".
 *
 * @property int $id
 * @property string $referralCode
 * @property string $referralDate
 * @property string $referralTime
 * @property int $receivingAgencyId
 * @property int $acceptingAgencyId
 * @property int $accepting_id
 * @property int $lab_id
 * @property int $customer_id
 * @property int $paymentType_id
 * @property string $modeofreleaseId
 * @property int $purposeId
 * @property int $discount_id
 * @property string $sampleArrivalDate
 * @property string $samplereceivedDate
 * @property string $reportDue
 * @property string $conforme
 * @property string $receivedBy
 * @property int $gratis
 * @property int $cancelled
 * @property int $state
 * @property int $validation_status
 * @property int $status
 * @property string $create_time
 * @property string $update_time
 * @property string $reason
 */
class Referral extends \yii\db\ActiveRecord
{
    public $temp_modeofrelease;
    public $samples;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referral';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('oldreferraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referralCode', 'referralDate', 'referralTime', 'receivingAgencyId', 'acceptingAgencyId', 'accepting_id', 'lab_id', 'customer_id', 'paymentType_id', 'modeofreleaseId', 'purposeId', 'sampleArrivalDate', 'samplereceivedDate', 'reportDue', 'conforme', 'receivedBy', 'cancelled', 'validation_status', 'status', 'create_time', 'reason'], 'required'],
            [['referralDate', 'sampleArrivalDate', 'samplereceivedDate', 'reportDue', 'create_time', 'update_time'], 'safe'],
            [['receivingAgencyId', 'acceptingAgencyId', 'accepting_id', 'lab_id', 'customer_id', 'paymentType_id', 'purposeId', 'discount_id', 'gratis', 'cancelled', 'state', 'validation_status', 'status'], 'integer'],
            [['referralCode', 'conforme', 'receivedBy'], 'string', 'max' => 50],
            [['referralTime'], 'string', 'max' => 10],
            [['modeofreleaseId'], 'string', 'max' => 20],
            [['reason'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referralCode' => 'Referral Code',
            'referralDate' => 'Referral Date',
            'referralTime' => 'Referral Time',
            'receivingAgencyId' => 'Receiving Agency ID',
            'acceptingAgencyId' => 'Accepting Agency ID',
            'accepting_id' => 'Accepting ID',
            'lab_id' => 'Lab ID',
            'customer_id' => 'Customer ID',
            'paymentType_id' => 'Payment Type ID',
            'modeofreleaseId' => 'Modeofrelease ID',
            'purposeId' => 'Purpose ID',
            'discount_id' => 'Discount ID',
            'sampleArrivalDate' => 'Sample Arrival Date',
            'samplereceivedDate' => 'Sample Received Date',
            'reportDue' => 'Report Due',
            'conforme' => 'Conforme',
            'receivedBy' => 'Received By',
            'gratis' => 'Gratis',
            'cancelled' => 'Cancelled',
            'state' => 'State',
            'validation_status' => 'Validation Status',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'reason' => 'Reason',
        ];
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getSamples()
    {
        return $this->hasMany(Sample::className(), ['referral_id' => 'id']);
    }

    public function getAgency()
    {
        return $this->hasOne(Agency::className(), ['id' => 'receivingAgencyId']);
    }

    static function generateReferralCode($labId, $referralId){
        //$monthYear = date('mY', strtotime($this->referralDate));
        $monthYear = date('mY');

        $lastReferralCode = Referralcode::find()->where(['year'=>date('Y'),'lab_id'=>$labId])->orderBy('number DESC, id DESC')->one();
        
        if(isset($lastReferralCode)){
            $number = Referral::addZeros($lastReferralCode->number + 1);
        }else{
            $number = Referral::addZeros(1);
        }
        
        $lab = Lab::findOne($labId);
        $ref = Referral::findOne($referralId);
        $agency = Agency::findOne($ref->receivingAgencyId);
        $code = $agency->code.'-'.$monthYear.'-'.$lab->labCode.'-'.$number;
        
        $referralCode = new Referralcode;
        $referralCode->referral_id = $referralId;
        $referralCode->referralCode = $code;
        $referralCode->agency_id = $ref->receivingAgencyId;
        $referralCode->lab_id = $labId;
        $referralCode->number = $number;
        $referralCode->year = date('Y');
        
        if($referralCode->save())
            return $code;
        else
            //return $referralCode->getErrors();
            return 'Error.';
            
        //return $agency->code.'-'.$monthYear.'-'.Referral::addZeros(count($referralCode)+1);
    }

    static function addZeros($count){
        if($count < 10)
            return '000'.$count;
        elseif ($count < 100)
            return '00'.$count;
        elseif ($count < 1000)
            return '0'.$count;
        elseif ($count >= 1000)
            return $count;
    }
}
