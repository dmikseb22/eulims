<?php

use yii\helpers\Html;
//use yii\grid\GridView;
//use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\models\lab\Lab;
use kartik\grid\Module;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\export\ExportMenu;
use kartik\grid\DataColumn;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daily Samples Report';
$this->params['breadcrumbs'][] = $this->title;

$pdfHeader="OneLab-Enhanced ULIMS";
$pdfFooter="{PAGENO}";


$js=<<<JS

$('#w0').change(function(){   
	var today = $("#w0").val();
	var lab = $("#lab_id").val();

		if(today != '')
        $.ajax({
            url: "/reports/lab/statistic/daily",
            type: 'POST',
            dataType: "JSON",
            data: {
                today: today,
				lab_id: lab
            },
            success: function(response) {
                $("#request").text(response.request);
                $("#sample").text(response.sample);
                $("#analysis").text(response.analysis);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
});

$('#lab_id').change(function(){   
	var today = $("#w0").val();
	var lab = $("#lab_id").val();

        $.ajax({
            url: "/reports/lab/statistic/daily",
            type: 'POST',
            dataType: "JSON",
            data: {
                today: today,
				lab_id: lab
            },
            success: function(response) {
                $("#request").text(response.request);
                $("#sample").text(response.sample);
                $("#analysis").text(response.analysis);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
});

JS;

$this->registerJs($js,\yii\web\View::POS_READY);

?>


<?php $this->registerJsFile("/js/services/services.js"); ?>
<div class="accomplishment-index">
	<div class="panel panel-default col-xs-12">
		<div class="panel-body">

			<div class="row">
				<div class="col-md-4">
					<div id="lab-name">
						<?php
							echo '<label class="control-label">Laboratory </label>';
							echo Select2::widget([
								'name' => 'lab_id',
								'id' => 'lab_id',
								'value' => $lab,
								'data' => $laboratories,
								'theme' => Select2::THEME_KRAJEE,
								'options' => ['placeholder' => 'Select Laboratory '],
								'pluginOptions' => [
									'allowClear' => true,
								],
							]);
						?>
						<span class="error-lab text-danger" style="position:fixed;"></span>
					</div>
				</div>
				<div class="col-md-8">
				<label class="control-label">Date </label>
				<?php 
					echo DatePicker::widget([
						'name'  => 'from_date',
						'value' => $date,
						'pluginOptions' => [
							'format' => 'yyyy-mm-dd',
							'autoclose'=>true,
							'allowClear' => true
						]
					]);
				?>
					<!-- <label class="control-label">Date </label>
					<input type="date" id="dropdowndate" class="form-control"> -->
				</div>
			</div>

			<br><br>				
			<div class="row">
				<div class="col-lg-4 col-xs-8">
					<div class="small-box bg-red">
						<div class="inner">
							<h3 id="request"><?php echo $request; ?></h3>
							<p>Request</p>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-xs-8">
					<div class="small-box bg-green">
						<div class="inner">
							<h3 id="sample"><?php echo $sample; ?></h3>
							<p>Samples</p>
						</div>
					</div>
				</div>


				<div class="col-lg-4 col-xs-8">
					<div class="small-box bg-yellow">
						<div class="inner">
							<h3 id="analysis"><?php echo $analysis; ?></h3>
							<p>Analysis</p>
						</div>
					</div>
				</div>
				
			</div>


		</div>
	</div>
</div>

