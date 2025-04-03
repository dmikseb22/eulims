<?php

namespace frontend\modules\lab\models;

use Yii;
use common\models\system\Rstl;
use common\components\Functions;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\lab\Sample;
use common\models\lab\SampleregisterUser;
use common\models\lab\Analysis;

/**
 * Extended model from lab Sample
 *
**/

class Sampleextend extends Sample
{
	const SCENARIO_CANCEL_SAMPLE = 'cancelsample';

	public function rules()
    {
        return [
            [['remarks'], 'required', 'on' => self::SCENARIO_CANCEL_SAMPLE],
        ];
    }

    public function showParameter($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);

        $testname = "";
        if(count($data) > 0){
        	foreach($data as $test){
				$testname .= $test['testname']."<br />";
			}
		}
		return $testname;
    }

    public function showStartDate($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);

        $startDate = "";
        if(count($data) > 0){
        	foreach($data as $date){
				$startDate .= $date['start_date']."<br />";
			}
        }
        return $startDate;
    }

    public function showEndDate($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);

        $endDate = "";
        if(count($data) > 0){
        	foreach($data as $date){
				$endDate .= $date['end_date']."<br />";
			}
        }
        return $endDate;
    }

    public function showDisposedDate($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);
        
        $disposedDate = "";
        if(count($data) > 0){
        	foreach($data as $date){
				$disposedDate .= $date['disposed_date']."<br />";
			}
        }
        return $disposedDate;
    }

    public function showMannerDisposal($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        // $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
        //     [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);
        //get the Analysis
        $data = Analysis::find()
            ->leftJoin('tbl_tagging', 'tbl_analysis.analysis_id=tbl_tagging.analysis_id')
            ->where(['sample_id'=>$sampleId])
            ->all();
        $mannerDisposal = "";
        if(count($data) > 0){
        	foreach($data as $manner){
				$mannerDisposal .= $manner->tagging['manner']."<br />";
			}
        }
        return $mannerDisposal;
    }

    public function showAnalyst($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);

        $analyst = "";
        if(count($data) > 0){
        	foreach($data as $user){
				$analyst .= SampleregisterUser::getUser($user['user_id'])."<br />";
			}
        }
        return $analyst;
    }
}
