<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Functions;
/* 
 * Project Name: eulims_ * 
 * Copyright(C)2019 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 07 16, 19 , 3:17:11 PM * 
 * Module: _viewtracking * 
 */

$func = new Functions();
$rstl_id=$rstl_id=(int) Yii::$app->user->identity->profile->rstl_id;

if($model['receiving_agency_id'] == $rstl_id){
    if ($modelRefTrackreceiving == ""){
        echo Html::button('<span class="glyphicon glyphicon-plus"></span> Add Referral Track', ['value'=>"/referrals/referraltrackreceiving/create?referralid=$model[referral_id]", 'class' => 'btn btn-success','title' => Yii::t('app', "Referral Track Receiving Lab"),'id'=>'btnreceivedtrack','onclick'=>'addreceivedtrack(this.value,this.title)']);
    }else{
        $Func="LoadModal('Update Tracking','/referrals/referraltrackreceiving/update?id=".$modelRefTrackreceiving->referraltrackreceiving_id."&refid=".$model['referral_id']."',true,500)";
        $UpdateButton='<button id="btnUpdate" onclick="'.$Func.'" type="button" style="float: left;padding-right:5px;margin-left: 5px" class="btn btn-primary"><i class="fa fa-pencil"></i> Update Tracking</button><br><br>';
    
        echo $UpdateButton.$trackreceiving=DetailView::widget([
            'model' =>$modelRefTrackreceiving,

            'attributes' => [
                [
                    'label'=>'Referred to',
                    'format'=>'raw',
                    'value'=>!empty($modelRefTrackreceiving->agencyreceiving) ? $modelRefTrackreceiving->agencyreceiving->name : null,
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Referral Code',
                    'format'=>'raw',
                    'value'=>$model['referral_code'],
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Date Received from Customer',
                    'format'=>'raw',
                    'value'=>!empty($modelRefTrackreceiving->sample_received_date) ? Yii::$app->formatter->asDate($modelRefTrackreceiving->sample_received_date, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No sample received date</i>",//$model->transactionnum,
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Courier',
                    'format'=>'raw',
                    'value'=>!empty($modelRefTrackreceiving->courier) ? $modelRefTrackreceiving->courier->name : "<i class='text-danger font-weight-bold h5'>No courier</i>",//$model->customer ? $model->customer->customer_name : "",
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Shipping Date',
                    'format'=>'raw',
                    'value'=>!empty($modelRefTrackreceiving->shipping_date) ? Yii::$app->formatter->asDate($modelRefTrackreceiving->shipping_date, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Calibration Specimen Received from Customer',
                    'format'=>'raw',
                    'value'=>!empty($modelRefTrackreceiving->cal_specimen_received_date) ? Yii::$app->formatter->asDate($modelRefTrackreceiving->cal_specimen_received_date, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],



            ],
        ]);
    }
    
 }
 else{
    if ($track == ""){
        echo Html::button('<span class="glyphicon glyphicon-plus"></span> Add Referral Track', ['value'=>'/referrals/referraltracktesting/create?referralid='.$model['referral_id'].'&receivingid='.$model['receiving_agency_id'], 'class' => 'btn btn-success','title' => Yii::t('app', "Referral Track Testing/Calibration Lab"),'id'=>'btntestingtrack','onclick'=>'addtestingtrack(this.value,this.title)']);
    }else{
        $Func="LoadModal('Update Tracking','/referrals/referraltracktesting/update?id=".$track->referraltracktesting_id."&refid=".$model['referral_id']."',true,500)";
        $UpdateButton='<button id="btnUpdate" onclick="'.$Func.'" type="button" style="float: left;padding-right:5px;margin-left: 5px" class="btn btn-primary"><i class="fa fa-pencil"></i> Update Tracking</button><br><br>';

        echo $UpdateButton.DetailView::widget([
            'model' =>$track,
            'attributes' => [

                [
                    'label'=>'Referred by',
                    'format'=>'raw',
                    'value'=>!empty($track->agencyreceiving) ? $track->agencyreceiving->name : null,//$model->transactionnum,
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Referral Code',
                    'format'=>'raw',
                    'value'=>$model['referral_code'],
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Date Received from Courier',
                    'format'=>'raw',
                    'value'=>!empty($track->date_received_courier) ? Yii::$app->formatter->asDate($track->date_received_courier, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No received date</i>",
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Analysis/Calibration Started',
                    'format'=>'raw',
                    'value'=>!empty($track->analysis_started) ? Yii::$app->formatter->asDate($track->analysis_started, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Analysis/Calibration Completed',
                    'format'=>'raw',
                    'value'=>!empty($track->analysis_completed) ? Yii::$app->formatter->asDate($track->analysis_completed, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Courier',
                    'format'=>'raw',
                    'value'=>!empty($track->courier) ? $track->courier->name : "<i class='text-danger font-weight-bold h5'>No courier</i>",
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
                [
                    'label'=>'Calibration Specimen Send back to Receiving Lab',
                    'format'=>'raw',
                    'value'=>!empty($track->cal_specimen_send_date) ? Yii::$app->formatter->asDate($track->cal_specimen_send_date, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No data</i>",
                    'valueColOptions'=>['style'=>'width:30%'], 
                    'displayOnly'=>true
                ],
            ],
        ]);
    }
 } 




