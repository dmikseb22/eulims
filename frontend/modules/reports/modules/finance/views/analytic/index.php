<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;



$this->registerCssFile("/css/modcss/financeanalytic.css", [
], 'css-fanalytic');


$this->registerJsFile("/js/finance/highcharts.js", [
], 'js-highcharts');

$this->registerJsFile("/js/finance/highcharts-more.js", [
], 'js-highcharts-more');
?>



<div class="row">
	<div class="col-xs-12 col-md-2">
		<div id ="toremove3" class="box-header with-border bg-bigpanel" data-intro="You can search or change the laboratory using this search form">
		    <?php $form = ActiveForm::begin(); ?>

	        <?= $form->field($reportform, 'lab_id')->widget(Select2::classname(), [
		        'data' => ArrayHelper::map(Lab::find()->where('active =:active',[':active'=>1])->all(),'lab_id','labname'),
		        'language' => 'en',
		        'options' => ['placeholder' => 'Select Lab','readonly'=>'readonly'],
		        'pluginOptions' => [
		            'allowClear' => false
		        ]
		    ])->label('Lab'); ?>

		    <?= $form->field($reportform, 'year')->textInput([
                                 'type' => 'number',
                                 'value'=>$year
                            ]) ?>

		    <div class="form-group">
		        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
		    </div>

			<?php ActiveForm::end(); ?>
		</div>
   	</div>
    <div class="col-xs-12 col-md-10">
    	<div class="box-header with-border bg-graphs">
    		<div id="toremove1" style="display: block" data-intro="This panel shows Monthly Generated Income">   
                <?php
                echo Highcharts::widget([
                    'id' => 'labColumnChart',
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                    ],
                    'title' => [
                        'text' => 'Income Generated - '.$labtitle ,
                        'style'=>['fontSize'=>'40px']
                    ],
                    'xAxis' => [
                        'title' => [
                            'text' => 'Year',
                            'style'=>['fontSize'=>'40px']
                        ],
                        'categories' => ['January' , 'February', 'March', 'April', 'May','June', 'July', 'August', 'September', 'October','November', 'December'],
                        'labels'=> ['style'=>['fontSize'=>'30px','font-weight'=>'bold']]
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Income',
                            'style'=>['fontSize'=>'40px']
                        ],
                        'stackLabels'=> ['enabled'=> true,'style'=>['fontSize'=>'30px']]
                    ],
                    'labels' => [
                        'items' => [
                            [
                                'style' => [
                                    'left' => '50px',
                                    'top' => '18px',
                                    'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                ],
                            ],
                        ],
                        'style'=>['fontSize'=>'30px']
                    ],
                    'plotOptions'=> ['column'=>['stacking'=>'normal']],
                    'tooltip'=>[
                        'headerFormat'=>'<b>{point.x}</b><br/>',
                        'pointFormat'=>'<b>{series.name}: {point.y}<b/><br/><b>Total: {point.stackTotal}</b>',
                        'style' => [
                                    'fontSize'=>'30px',
                                    'color'=>'green'
                                ],
                    ],
                    'series' => [
                        ['type' => 'column','name' => 'Actual Fees', 'data' => $actualfees,],
                        ['type' => 'column','name' => 'Discounts', 'data' => $discounts],
                        ['type' => 'column','name' => 'Gratis', 'data' => $gratis],
                        [
                            'type' => 'spline',
                            'tooltip'=>['headerFormat'=>'<b>{point.x}</b><br/>','pointFormat'=>'{series.name}: {point.y}'],
                            'name' => 'Avg. of Last 10 Years',
                            'data' => $prediction,
                            'marker' => [
                                'lineWidth' => 5,
                                'lineColor' => 'red',
                                'fillColor' => 'red',
                            ],
                        ],

                    ],
                    'legend'=> ['itemStyle'=>['fontSize'=>'25px']]
                ]
                ]);
                ?>
       		</div>
    	</div>
	</div>
	<div class="col-md-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body" id="toremove2" data-intro="Months with Green Color are validated by the Lab Managers while Red Ones are not! <br/> Thumbs Icon below are the factors for that month. <br/>Click a month to preview the summary">
                <div>
                    <div class="carousel-inner">
                    	<?php
                    	$month = 0;
						while ( $month<= 11) {
                            echo '<div class="col-md-1 col-sm-4 col-xs-12">';
                                if($month==0)  
								    echo '<a class="btn-openFigures" name="'.$year.'-'.sprintf("%02d", ($month+1)).'_'.$labId.'" id="btnjan">';
                                else
                                    echo '<a class="btn-openFigures" name="'.$year.'-'.sprintf("%02d", ($month+1)).'_'.$labId.'">';

								echo '<div class="info-box bg-'.$finalize[0].'">';
									echo '<span class="info-box-icon bg-entities bg-hover">';
									echo date('M',strtotime($year."-".($month+1)."-01"));
									echo '</span>';
								echo '</div>';
								echo '</a>';
								thumbsupsummary($factor_up[$month]);
								thumbsdownsummary($factor_down[$month]);
							echo '</div>';
							$month++;
						}
                    	?>
	                </div>
	            </div>
	        </div>
    	</div>
	</div>
	<div class="col-md-12" id="monthlyContent">
	</div>
</div>


<script type="text/javascript">
	function OpenMonth(header,url,closebutton,width){   
    $('#monthlyContent').html("<div style='text-align:center;'><img src='/images/img-loader64.gif' alt=''></div>");
    $('#monthlyContent').load(url);
}

jQuery(document).ready(function ($) {
    $('.btn-openFigures').click(function () {
        var toremove1 = document.getElementById('toremove1');
        var toremove2 = document.getElementById('toremove2');
        var toremove3 = document.getElementById('toremove3');

        toremove1.removeAttribute("data-intro")
        toremove2.removeAttribute("data-intro")
        toremove3.removeAttribute("data-intro")
        OpenMonth("Monthly Report", "/reports/finance/analytic/displaymonth?data="+this.name,true,'600px');
    });

    setTimeout(function() {
        introJs().setOption('doneLabel', 'Click January').start().oncomplete(function() {
        var toremove1 = document.getElementById('toremove1');
        var toremove2 = document.getElementById('toremove2');
        var toremove3 = document.getElementById('toremove3');

        toremove1.removeAttribute("data-intro")
        toremove2.removeAttribute("data-intro")
        toremove3.removeAttribute("data-intro")

        var x = document.getElementById("btnjan"); 
        OpenMonth("Monthly Report", "/reports/finance/analytic/displaymonth?data="+x.name,true,'600px');
          
        });
    }, 1000);
});
</script>

<?php 

function thumbsupsummary($data){
	$i = 0;
	while ($i < $data) {
		echo '<i class="fa fa-thumbs-up" style="color:green"></i>';	
		$i++;
	}
	return;
}

function thumbsdownsummary($data){
	$i = 0;
	while ($i < $data) {
		echo '<i class="fa fa-thumbs-down" style="color:red"></i>';	
		$i++;
	}
	return;
}

?>