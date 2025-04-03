<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use common\components\Functions;
use yii\bootstrap\Modal;
use kartik\dialog\Dialog;
use yii\web\JsExpression;
use yii\widgets\ListView;


$this->title = empty($model->referralCode) ? $model->id : $model->referralCode;
$this->params['breadcrumbs'][] = ['label' => 'Referral', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


 $Func="LoadModal('Cancellation of Request','/lab/cancelrequest/create?req=".$model->id."',true,500)";
    $CancelButton='<button id="btnCancel" onclick="'.$Func.'" type="button" style="float: right" class="btn btn-danger"><i class="fa fa-remove"></i> Cancel Request</button>';
?>
<div class="request-view ">
    

    <div class="row">
    <div class="col-md-8">
      <div class="box box-solid">
        <div class="box-header with-border" style="background-color:#00c0ef;">
          <i class="fa fa-paper"></i>

          <h3 class="box-title" ><b>Referral Details</b></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-6">
                <h4>Referral Code:<b> <?= ($model->referralCode != "") ? $model->referralCode : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>" ?></b></h4>
                <h4>Referral Date/Time:<b> <?= ($model->referralCode != "") ? Yii::$app->formatter->asDate($model->referralDate, 'php:F j, Y ').$model->referralTime : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>" ?></b></h4>
                <h4>Sample Received Date:<b> <?=!empty($model->samplereceivedDate) ? Yii::$app->formatter->asDate($model->samplereceivedDate, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>No sample received date</i>"?></b></h4>
                <h4>Estimated Due Date:<b> <?=($model->referralCode != "") ? Yii::$app->formatter->asDate($model->reportDue, 'php:F j, Y') : "<i class='text-danger font-weight-bold h5'>Pending referral request</i>"?></b></h4>
                <h4>-</h4>
                <h4>Received By: <b><?=$model->receivedBy?></b></h4>
                <h4>Refered By: <b><?= $model->receivingagency?></b></h4>
                <h4>Refered To: <b><?= $model->acceptingagency?></b></h4>
            </div>
            <div class="col-md-6">
                <h2>Customer Information <br><i class="text-info font-weight-bold h4"><?=$model->customer_id ?></i><i class='text-danger font-weight-bold h5'><br/>Other Information is hidden - Customer from Referral Network</i></h2>
                
            </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <div class="col-md-4">
        <div class="box box-solid"  style="background-color: #00c0ef;">
        <div class="box-header with-border">
          <i class="fa fa-note"></i>

          <h3 class="box-title" style="color: #fff;">Manuals</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="background-color: #00c0ef;">
                <h3><?= Html::a('How to refer', 'https://tinyurl.com/u79rtc8d',['target'=>"_blank",'style'=>'color:#fff']); ?></h3>
                <h3><?= Html::a('How to receive PSTC request <b>(soon)</b>', '#',['target'=>"_blank",'style'=>'color:#fff']); ?></h3>
               
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-4">
        <div class="box box-solid"  style="background-color: #0c981c;">
        <div class="box-header with-border">
          <i class="fa fa-note"></i>

          <h3 class="box-title" style="color: #fff;">
          <?php
                if($model->referralCode==""){
                    echo 'Confirm and Accept Referral';
                }else{
                    echo 'Confirmed and Accepted!'; 
                } ?>
            </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="background-color: #0c981c;">
                <?php
                if($model->referralCode==""){
                    $urls = '/referrals/referral/confirmedaccept?referral_id='.$model->id;
                        echo '<a class="toclick" name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</a>';
                }else{
                    echo "<a href='https://referral.onelab.ph/lab/referral/print?id=".$model->id."' class='btn btn-success' target='_blank' style='margin-left: 5px'><i class='fa fa-print'></i> Print Referral from older system</a><br/>";
                    echo "<h4 style='color:#fff;'>OR</h4>";
                    echo '<i class="font-weight-bold h5" style="color:#ffffff;"><br/>(DO NOT PRINT if the referral is created using older version!)</i><br/>';
                    echo "<a href='/referrals/referral/print?id=".$model->id."' class='btn btn-success' target='_blank' style='margin-left: 5px'><i class='fa fa-print'></i> Print Referral from EULIMS</a>";
                } ?>
               
        </div>
        <!-- /.box-body -->
      </div>
    </div>

    <!-- ./col -->
    </div>
    <!-- Samples and Analyses-->
     <?= $this->render('_samples', [
        'model' => $model,
    ]) ?>
    <!-- AGency to refer-->


    <div id="agencyContent">
        <div style='text-align:center;'>
            <h1>Agencies</h1>
    <img src='/images/img-loader64.gif' alt=''>
</div>
</div>

</div>
<?php 
if($model->receivingAgencyId==\Yii::$app->user->identity->profile->rstl_id&&$model->referralCode ==NULL){
?>
<script type="text/javascript">
jQuery(document).ready(function ($) {

    setTimeout(function() {
        $('#agencyContent').load("/referrals/referral/agencies?id=" +<?= $model->id?>);
    }, 2000);
});
</script>
<?php

}else{
?>
<script type="text/javascript">
jQuery(document).ready(function ($) {

    setTimeout(function() {
        $('#agencyContent').html("");
    }, 1000);

     setTimeout(function() {
        $('.toclick').each(function(i, obj) {

            $(this).load(this.name);
        });

    }, 2000);

});
</script>
<?php
}
?>
