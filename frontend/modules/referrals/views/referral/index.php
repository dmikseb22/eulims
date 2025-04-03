<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use \yii\helpers\ArrayHelper;
use common\models\system\Rstl;
use common\components\Functions;
use yii\bootstrap\Modal;
use yii\helpers\Url;
// use yii\grid\GridView;


$this->title = 'Referral';
$this->params['breadcrumbs'][] = ['label' => 'Lab', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->registerJsFile("/js/services/services.js"); ?>

<div class="referral-index">
     <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <h2 class="box-title">Referrals</h2>
                <hr>
                <button type='button' onclick='LoadModal("Create Referral Request","/referrals/referral/create")' class="btn btn-success"><i class="fa fa-book-o"></i> Create Referral Request</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="form-group">
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="col-md-3">
                            <?= $form->field($model, 'referralCode')->textInput([
                                 // 'type' => 'number',
                                 // 'value'=>$year
                            ]) ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'referralDate')->textInput([
                                 'type' => 'date',
                                 // 'value'=>$year
                            ]) ?>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
              <table id="referral_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>id</th>
                  <th>Reference Code</th>
                  <th>Referral Date</th>
                  <th>Customer</th>
                  <th>Referred By</th>
                  <th>Referred To</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                if($dataProvider->items){
                    foreach ($dataProvider->items as $data) {
                        echo "<tr>";
                        echo "<td>";
                        echo $data->id;
                        echo "</td>";
                        echo "<td>";
                        echo $data->referralCode;
                        echo "</td>";
                        echo "<td>";
                        echo $data->referralDate;
                        echo "</td>";
                        echo "<td>";
                        echo $data->customer_id;
                        echo "</td>";
                        echo "<td>";
                        echo $data->receivingagency;
                        echo "</td>";
                        echo "<td>";
                        echo $data->acceptingagency;
                        echo "</td>";
                        echo "<td>";
                        // echo "<button type='button' value = '/referrals/referral/view?id=".$data->id."' onclick='location.href=this.value' target='_blank' class='btn btn-success'>View</button>";
                        echo Html::a('View', ['/referrals/referral/view?id='.$data->id], ['target'=>'_blank','class' => 'btn btn-primary', 'role' => 'modal-remote']);
                        echo "</td>";
                        echo "</tr>";
                    }
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
</div>
