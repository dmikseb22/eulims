<?php

namespace common\models\lab;

use Yii;
use yii\db\Query;
use common\models\lab\Customer;
use common\models\lab\CustomerBooking;
use common\models\lab\Modeofrelease;
use common\models\lab\Purpose;
use common\models\lab\Sampletype;

/**
 * This is the model class for table "tbl_booking".
 *
 * @property int $booking_id
 * @property string $scheduled_date
 * @property string $booking_reference
 * @property string $description
 * @property int $rstl_id
 * @property string $date_created
 * @property int $qty_sample
 * @property int $customer_id
 * @property int $sampletype_id
 */
class Booking extends \yii\db\ActiveRecord
{
    public $mypurpose;
	public $captcha;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_booking';
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
            [['scheduled_date', 'qty_sample', 'customer_id','samplename','description','qty_sample','sampletype_id','purpose','captcha'], 'required'],
            [['scheduled_date', 'date_created','booking_status','samplename','modeofrelease_ids','reason','customerstat'], 'safe'],
            [['rstl_id', 'qty_sample', 'customer_id','sampletype_id'], 'integer'],
            [['booking_reference'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
			[['captcha'], 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'booking_id' => 'Booking ID',
            'scheduled_date' => 'Scheduled Date',
            'booking_reference' => 'Booking Reference',
            'description' => 'Description',
            'rstl_id' => 'Rstl ID',
            'date_created' => 'Date Created',
            'qty_sample' => 'Qty Sample',
            'customer_id' => 'Customer ID',
			'sampletype_id' => 'Sample Type',
			'samplename' => 'Sample Name',
        ];
    }
    /*public function getCustomer()
    {
        return $this->hasOne(CustomerBooking::className(), ['customer_booking_id' => 'customer_id']);
    }*/
	
	public function getCustomer()
    {
        if($this->customerstat == 1){
            return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);    
        }else{
            return $this->hasOne(CustomerBooking::className(), ['customer_booking_id' => 'customer_id']);
        }   
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord)
            {
                $lastid=(new Query)
                    ->select('MAX(booking_id) AS lastnumber')
                    ->from('eulims_lab.tbl_booking')
                    ->one();
                $lastnum=$lastid["lastnumber"]+1;
                $rstl_id=11;
           
                $string = Yii::$app->security->generateRandomString(9);
                $next_refnumber=$string.$lastnum;//random strings+(lastid+1)
                $this->booking_reference = $next_refnumber;
            }

            return parent::beforeSave($insert);
        }
    }
    public function getModeofrelease()
    {
        return $this->hasOne(Modeofrelease::className(), ['modeofrelease_id' => 'modeofrelease_ids']);
    }

    public function getPurpose(){
        return $this->hasOne(Purpose::className(), ['purpose_id' => 'purpose']);
    }

    public function getSampletype(){
        return $this->hasOne(Sampletype::className(),['sampletype_id' => 'sampletype_id']);
    }


}

