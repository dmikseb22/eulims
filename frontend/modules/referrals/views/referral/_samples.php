<?php

use yii\helpers\Html;
use common\models\system\Profile;
?>

<div class="referral-index">
     <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header" style="background-color:#00c0ef;">
                <h2 class="box-title"><b>Samples</b></h2>
			</div>	
                <hr>
                <?php
                //get the rstl_id 
                $profile = Profile::find()->where(['user_id'=>\Yii::$app->user->id])->one();
                if(($model->referralCode=="")&&($model->receivingAgencyId == $profile->rstl_id)){
                     ?>
                    <button type='button' onclick='LoadModal("Register Sample","/referrals/sample/create?id=<?=$model->id?>")' class="btn btn-success"><i class="fa fa-book-o"></i> Register Sample</button>
                     <?php
                }
                ?>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="referral_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width='10%'>Sample Code</th>
                  <th width='10%'>Type</th>
                  <th width='20%'>Sample</th>
                  <th width='50%'>Description</th>
                  <?php
                    if($model->referralCode==""){
                        ?>
                        <th width='10%'>Actions</th>
                        <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php 
                if($model->samples){
					//$url ='/referrals/sample/delete?id='.$model->id;
                    foreach ($model->samples as $data) {
                        echo "<tr>";
                        echo "<td>";
                        echo $data->sampleCode;
                        echo "</td>";
                        echo "<td>";
                        echo $data->type;
                        echo "</td>";
                        echo "<td>";
                        echo $data->sampleName;
                        echo "</td>";
                        echo "<td>";
                        echo $data->description;
                        echo "</td>";
                        if($model->referralCode==""){
                            echo "<td>";
                            echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', ['class'=>'btn btn-primary','title'=>'Update Sample','onclick' => 'updateSample('.$data->id.')']);
                            echo Html::a('<span class="glyphicon glyphicon-trash"></span>', '/referrals/sample/delete?id='.$data->id,['data-confirm'=>"Are you sure you want to delete <b>".$data->sampleName."</b>?",'data-method'=>'post','class'=>'btn btn-danger','title'=>'Delete Sample','data-pjax'=>'0']);
                            echo "</td>";       
                        }
                    }
                         echo "</tr>";
                }else{
                     echo "<tr><td colspan = '5'>Empty</td></tr>";
                }
                ?>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header" style="background-color:#00c0ef;">
                <h2 class="box-title"><b>Analyses</b></h2>
			</div>	
                <hr>
                <?php
                if($model->referralCode==""){
                    ?>
                     <button type='button' onclick='LoadModal("Assign Test","/referrals/analysis/create?id=<?=$model->id?>",true,"900")' class="btn btn-success"><i class="fa fa-book-o"></i> Assign Test</button>
                    <?php
                }
                ?>
           
            <!-- /.box-header -->
            <div class="box-body">
              <table id="referral_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width='10%'>Sample Code</th>
                  <th width='10%'>Sample</th>
                  <th width='35%'>Test/Calibration Requested</th>
                  <th width='20%'>Test Method</th>
                  <th width='5%'>Quantity</th>
                  <th width='10%'>Unit Price</th>
                  <?php
                    if($model->referralCode==""){
                        ?>
                        <th width='10%'>Actions</th>
                        <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php 
   
                    foreach ($model->samples as $sample) {
                       
                        foreach ($sample->analyses as $test) {
                          echo "<tr>";
                          echo "<td>";
                          echo $sample->sampleCode;
                          echo "</td>";
                          echo "<td>";
                          echo $sample->sampleName;
                          echo "</td>";
                          echo "<td>";
                          echo $test->testName;
                          echo "</td>";
                          echo "<td>";
                          echo $test->method;
                          echo "</td>";
                          echo "<td>";
                          echo 1;
                          echo "</td>";
                          echo "<td>";
                          echo $test->fee;
                          echo "</td>";
                          if($model->referralCode==""){
                           
                            echo "<td>";
                            echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', ['class'=>'btn btn-primary','title'=>'Update Sample','onclick' => 'updateSample('.$data->id.')']);
                            echo Html::a('<span class="glyphicon glyphicon-trash"></span>', '/referrals/analysis/delete?id='.$test->id.'&refid='.$sample->referral_id,['data-confirm'=>"Are you sure you want to delete <b>".$test->testName." <br> Method: </b>".$test->method."</b>",'data-method'=>'post','class'=>'btn btn-danger','title'=>'Delete Analysis','data-pjax'=>'0']);
                            echo "</td>";
                        }
                          echo "</tr>";
                        }
                }
                ?>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
</div>
<script type="text/javascript">

    $('#sample-grid tbody td').css('cursor', 'pointer');
    function updateSample(id){
       var url = '/referrals/sample/update?id='+id;
        $('.modal-title').html('Update Sample');
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
</script>