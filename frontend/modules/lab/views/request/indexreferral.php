<?php

use yii\helpers\Html;
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

<div class="fee-index">

     <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Referrals</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Reference Code</th>
                  <th>Referral Date</th>
                  <th>Customer</th>
                  <th>Referred By</th>
                  <th>Referred To</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                    foreach ($dataProvider->items as $data) {
                        echo "<tr>";
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
                        echo $data->receivingAgencyId;
                        echo "</td>";
                        echo "<td>";
                        echo $data->acceptingAgencyId;
                        echo "</td>";
                        echo "</tr>";
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
   

    <?php 
    // GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'columns'=> ['id']
    // ]); 
    ?>
</div>
