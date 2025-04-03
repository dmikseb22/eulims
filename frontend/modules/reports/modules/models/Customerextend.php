<?php

namespace frontend\modules\reports\modules\models;

use Yii;
use common\models\system\Rstl;
use common\components\Functions;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\lab\Customer;
use common\models\address\Barangay;
/**
 * Extended model from lab Customer
 *
**/

class Customerextend extends Customer
{
    public $from_date, $to_date, $lab_id;

    public function statCustomerServed($labId,$customerId,$startDate,$endDate,$generateType,$filterType,$filterId,$requestType)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $query = $function->ExecuteStoredProcedureOne("spCustomerServed(:rstlId,:labId,:customerId,:startDate,:endDate,:generateType,:filterType,:filterId,:requestType)", 
            [':rstlId'=>$rstlId,':labId'=>$labId,':customerId'=>$customerId,':startDate'=>$startDate,':endDate'=>$endDate,':generateType'=>$generateType,':filterType'=>$filterType,':filterId'=>$filterId,':requestType'=>$requestType], $connection);
        return $query['Counter'];

        //echo $GLOBALS['rstl_id'].' '.$labId.' '.$customerId.' '.$startDate.' '.$endDate.' '.$generateType.' '.$filterType.' '.$filterId.' '.$requestType;
    }

    //(RSTLID INT(11),LabID INT(11), CustomerID INT(11), FromRequestDate VARCHAR(30),
    //ToRequestDate VARCHAR(30),`GenerateType` INT(11),`FilterType` INT(11),`FilterID` INT(11),RequestType INT(11))

    //public function getCompleteaddress1()
    //{
         // return $this->hasOne(Classification::className(), ['classification_id' => 'classification_id']);
         //$address = Barangay::findOne($this->barangay_id);
         //return $address->cityMunicipality->province->region->region.' '.$address->cityMunicipality->province->province.' '.$address->cityMunicipality->city_municipality.' '.$address->barangay;
        //return $this->barangay->
    //}
}
