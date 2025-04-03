<?php

namespace frontend\modules\reports\modules\models;

use Yii;
use common\models\system\Rstl;
use common\components\Functions;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\lab\Request;
use common\models\lab\Sample;
/**
 * Extended model from lab Request
 *
**/

class Requestextend extends Request
{
    public $totalrequests ,$month, $monthnum;
    public $from_date, $to_date, $lab_id;

    public function countSummary($labId,$requestDate,$startDate,$endDate,$summaryType,$requestType)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $query = $function->ExecuteStoredProcedureOne("spSummaryforSamples(:rstlId,:labId,:requestDate,:startDate,:endDate,:summaryType,:requestType)", 
            [':rstlId'=>$rstlId,':labId'=>$labId,':requestDate'=>$requestDate,':startDate'=>$startDate,':endDate'=>$endDate,':summaryType'=>$summaryType,':requestType'=>$requestType], $connection);
        return $query['Counter'];
    }

    public function computeAccomplishment($labId,$requestDate,$startDate,$endDate,$generateType,$requestType)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $query = $function->ExecuteStoredProcedureOne("spAccomplishmentReport(:rstlId,:labId,:requestDate,:startDate,:endDate,:generateType,:requestType)", 
            [':rstlId'=>$rstlId,':labId'=>$labId,':requestDate'=>$requestDate,':startDate'=>$startDate,':endDate'=>$endDate,':generateType'=>$generateType,':requestType'=>$requestType], $connection);
        return $query['Counter'];
    }


    //Bergel - get the count of the relation
      public function getSamplescount()
    {
        return Sample::find()->where(['request_id' => $this->request_id])->count();
    }

    public function getCustomerStats($yearmonth,$type=null){
        $reqs =  Requestextend::find()->select(['tbl_customer.customer_id', ])->where(['DATE_FORMAT(`request_datetime`, "%Y-%m")' => $yearmonth])->andWhere(['>','status_id',0])->leftJoin('tbl_customer', 'tbl_request.customer_id=tbl_customer.customer_id')->andWhere(['tbl_customer.classification_id'=>$type,'lab_id'=>Yii::$app->user->identity->profile->lab_id])->distinct()->count();

         return $reqs;
    }

    public function getCustomerStatsData($yearmonth,$type=null){
        $reqs =  Requestextend::find()->select(['tbl_customer.customer_id', 'tbl_customer.customer_name'])->where(['DATE_FORMAT(`request_datetime`, "%Y-%m")' => $yearmonth])->andWhere(['>','status_id',0])->leftJoin('tbl_customer', 'tbl_request.customer_id=tbl_customer.customer_id')->andWhere(['tbl_customer.classification_id'=>$type])->all();

        return $reqs;
    }
    public function getStats($yearmonth,$lab_id,$type){
        // return Sample::find()->with(['Request' => function($query){
        //     $query->where(['DATE_FORMAT(`request_datetime`, "%Y-%m")' => $yearmonth]);
        // }])->count();   

        $total = 0;
        if($type==1){
            //total number of samples
            $reqs =  Requestextend::find()->select(['request_id'])->where(['DATE_FORMAT(`request_datetime`, "%Y-%m")' => $yearmonth,'lab_id'=>$lab_id])->andWhere(['>','status_id',0])->with(['samples' => function($query){
                $query->andWhere(['active'=>'1']);
            }])->all();

            foreach ($reqs as $req) {
                $total += count($req->samples);
            }
        }elseif($type==2){
            //total number of analysis
            $reqs =  Requestextend::find()->select(['request_id'])->where(['DATE_FORMAT(`request_datetime`, "%Y-%m")' => $yearmonth,'lab_id'=>$lab_id])->andWhere(['>','status_id',0])->with(['analyses' => function($query){
                $query->andWhere(['<>','references','-'])->andWhere(['cancelled'=>'0']);
            }])->all();

            foreach ($reqs as $req) {
                $total += count($req->analyses);
            }
        }elseif($type==3){
            //total number of discount

            $reqs =  Requestextend::find()
            ->where(['DATE_FORMAT(`request_datetime`, "%Y-%m")' => $yearmonth,'lab_id'=>$lab_id,'status_id'=>1])
            ->all();
            $amount =0;
            $subtotal = 0;
            foreach ($reqs as $req) {
                //check the samples
                $subtotal = 0;
               if($req->samples){
                    foreach ($req->samples as $sample) {
                        if($sample->analyses){
                            foreach ($sample->analyses as $analysis) {
                               $subtotal += $analysis->fee; 
                            }
                        }
                    }

                    $amount += ($subtotal * ($req->discount / 100 ));
               }
            }
            $total = $amount ;
        }


        return $total;
    }
}
