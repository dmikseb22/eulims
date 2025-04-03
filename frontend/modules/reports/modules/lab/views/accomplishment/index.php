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
use common\models\lab\Reportsummary;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accomplishment Report';
$this->params['breadcrumbs'][] = $this->title;

$pdfHeader="OneLab-Enhanced ULIMS";
$pdfFooter="{PAGENO}";
?>


<?php $this->registerJsFile("/js/services/services.js"); ?>
<div class="accomplishment-index">
	<div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
	   	<a href="#" class="close" data-dismiss="alert" >×</a>
	  	<p class="note" style="color:#265e8d"><b>Note:</b></br> We optimized the query performance of this page.</br>To get the full year performance, use the search feature below. </p>
	  	<p class="note" style="color:#265e8d">Getting the full year accomplishment takes time to load.<b>   ~Berg</b></p>
  	</div>
    <!-- /.info-box-content -->

    </div>
<div class="panel panel-default col-xs-12">
        <div class="panel-body">
    	<?php
    		$form = ActiveForm::begin([
			    'id' => 'accomplishment-form',
			    'options' => [
					'class' => 'form-horizontal',
					//'data-pjax' => true,
				],
				'method' => 'get',
			])
    	?>
    
    		<div class="row">
		        <div id="lab-name" style="width:25%;position: relative; float:left;margin-right: 20px;">
		            <?php
		            	echo '<label class="control-label">Laboratory </label>';
						echo Select2::widget([
						    'name' => 'lab_id',
						    'id' => 'lab_id',
						    'value' => $lab_id,
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

		         <div id="date_range" style="position: relative; float: left;margin-left: 20px;">
    				<?php
				        echo '<label class="control-label">Year </label>';
		    		?>
		    		<?= Html::textinput('year',$year, $options=['class'=>'form-control','maxlength'=>10, 'style'=>'width:350px','type'=>'number', 'id'=>'the-year']) ?>

		    		<span class="error-date text-danger" style="position:fixed;"></span>
		    	</div>

		    	 <div style="width:15%;position: relative; float:left;margin: 27px 0 0 10px;">
		    		<button type="button" id="btn-filter" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>
		    	</div>
		    </div>
		    <?php ActiveForm::end(); ?>

       </div>
       <br>
	    <div class="row">
        	<?php
			    $gridColumns= [
			    	['class' => 'kartik\grid\ActionColumn',
			    		'header'=>'Details',
						'contentOptions' => ['style' => 'width: 8.7%'],
						'template' => '{view}',
						'buttons'=>[
							'view'=>function ($url, $model) use($lab_id) {
								return Html::button('<span class="glyphicon glyphicon-print"></span>', ['value'=>Url::to(['/lab/tagging/monthlyreport','month'=>Yii::$app->formatter->asDate($model->request_datetime, 'php:M'), 'year'=>Yii::$app->formatter->asDate($model->request_datetime, 'php:Y'), 'lab_id' => $lab_id]), 'class' => 'btn btn-primary','onclick'=>'LoadModal(this.title, this.value ,true, 1850);','title' => Yii::t('app', "Monthly Report")]);
							},
						   
						],
					],
			    	'month',
			    	[
						'header'=> 'No. of Request',
						'headerOptions' => ['class' => 'text-center'],
			    		'contentOptions' => ['class' => 'text-center'],
						'value'=> function( $model ){
			    			return $model->totalrequests;
			    		},
			    		'pageSummary'=>true,
        				'pageSummaryFunc'=>GridView::F_SUM,
        				'pageSummaryOptions'=>['class'=>'text-center text-primary'],
					],
					[
						'header'=> 'No. of Samples',
						'headerOptions' => ['class' => 'text-center'],
			    		'contentOptions' => ['class' => 'text-center'],
			    		'value'=> function( $model ) use($year,$lab_id){
			    			$monthyear = $year."-".$model->monthnum;
			    			return $model->countTables($monthyear,$lab_id,'samples');

			    		},
			    		'pageSummary'=>true,
        				'pageSummaryFunc'=>GridView::F_SUM,
        				'pageSummaryOptions'=>['class'=>'text-right text-primary'],
					],
					[
						'header'=> 'No. of Analyses',
						'headerOptions' => ['class' => 'text-center'],
			    		'contentOptions' => ['class' => 'text-center'],
			    		'value'=> function( $model ) use($year,$lab_id){
			    			$monthyear = $year."-".$model->monthnum;
			    			return $model->countTables($monthyear,$lab_id,'analysis');

			    		},
			    		'pageSummary'=>true,
        				'pageSummaryFunc'=>GridView::F_SUM,
        				'pageSummaryOptions'=>['class'=>'text-center text-primary'],
					],
					[
						'headerOptions' => ['class' => 'text-center'],
			    		'header'=> 'Income Generated (Actual Fees Collected)',
			    		'contentOptions' => ['class' => 'text-center'],
			            'format'=>['decimal', 2],
			    		'value'=> function( $model ){
			    			return $model->total;

			    		},
			    		'pageSummary'=>true,
        				'pageSummaryFunc'=>GridView::F_SUM,
        				'pageSummaryOptions'=>['class'=>'text-center text-primary'],
					],
					[ //logically it wll return 0, but we will get back to this if there's anything needed
						'header'=> 'Gratis',
						'headerOptions' => ['class' => 'text-center'],
						'contentOptions' => ['class' => 'text-center'],
						'format'=>['decimal', 2],
			    		'value'=> function( $model ) use($year,$lab_id){
			    			$monthyear = $year."-".$model->monthnum;
			    			return $model->countTables($monthyear,$lab_id,'gratis');

			    		},
			    		'pageSummary'=>true,
        				'pageSummaryFunc'=>GridView::F_SUM,
        				'pageSummaryOptions'=>['class'=>'text-center text-primary'],
					],
					[
						'header'=> 'Discount',
						'headerOptions' => ['class' => 'text-center'],
			    		'contentOptions' => ['class' => 'text-center'],
			    		'format'=>['decimal', 2],
			    		'value'=> function( $model ) use($year,$lab_id){
			    			$monthyear = $year."-".$model->monthnum;
						 	return  $model->countTables($monthyear,$lab_id,'discount');
			    		},
			    		'pageSummary'=>true,
        				'pageSummaryFunc'=>GridView::F_SUM,
        				'pageSummaryOptions'=>['class'=>'text-center text-primary'],
					],
					[
						'header'=> 'Gross',
						'headerOptions' => ['class' => 'text-center'],
			    		'contentOptions' => ['class' => 'text-center'],
			    		'format'=>['decimal', 2],
			    		'value'=> function( $model ) use($year,$lab_id){
							$monthyear = $year."-".$model->monthnum;
							$discount = $model->countTables($monthyear,$lab_id,'discount');
							$gratis = $model->countTables($monthyear,$lab_id,'gratis');
			    			return ($model->total + $discount + $gratis);
			    		},
			    		'pageSummary'=>true,
        				'pageSummaryFunc'=>GridView::F_SUM,
        				'pageSummaryOptions'=>['class'=>'text-center text-primary'],
			    	],
			  //   	['class' => 'kartik\grid\ActionColumn',	
			  //   		'header'=>'Verification',	
					// 	'contentOptions' => ['style' => 'width: 8.7%'],	
					// 	'template' => '{verify}',	
					// 	'buttons'=>[	
					// 		'verify'=>function ($url, $model) use($year, $lab_id) {	

					// 			//check if this month year is already finalize	
					// 			$summary = Reportsummary::find()->where(['lab_id'=>$lab_id,'year'=>$year,'month'=>$model->monthnum])->one();	

					// 			if ($summary)	
					// 				return Html::button('<span class="glyphicon glyphicon glyphicon-ok"></span>',['class' => 'btn btn-success','title' => Yii::t('app', "Already Submitted")]);	
					// 			else	
					// 				return Html::button('<span class="glyphicon glyphicon-ok"></span>', ['value'=>Url::to(['validate?data=hghghghty']),'class' => 'btn btn-danger modal_method','title' => Yii::t('app', "Monthly Report")]);	
					// 		},	
						   	
					// 	],	
					// ],
			    	
			    ];

			    echo GridView::widget([
			    	'id' => 'accomplishment-report',
			        'dataProvider'=>$dataProvider,
			        //'filterModel'=>$searchModel,
			        'showPageSummary'=>true,
			        'summary' => false,
			        'pjax'=>true,
	                'pjaxSettings' => [
	                    'options' => [
	                        'enablePushState' => false,
	                    ]
	                ],
	                'responsive'=>true,
			        'striped'=>false,
			        'hover'=>true,
			        'panel' => [
	                    'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Accomplishment Report</h3>',
	                    'type'=>'primary',
	                    'after'=>false,
	                    //'before'=>$exportMenu,
	                    //'headerOptions' => ['class' => 'text-center'],
	                ],
		        'exportConfig' => [
			    	GridView::PDF => [
		                'filename' => 'Accomplishment_Report('.$year.')',
		                'alertMsg'        => 'The PDF export file will be generated for download.',
		                'config' => [
		                    'methods' => [
		                        'SetHeader' => [$pdfHeader],
		                        'SetFooter' => [$pdfFooter]
		                    ],
		                    'options' => [
		                        'title' => 'Accomplishment Report',
		                        'subject' => 'Accomplishment_Report',
		                        'keywords' => 'pdf, preceptors, export, other, keywords, here'
		                    ],
		                ]
		            ],
		            GridView::EXCEL => [
		                'label'           => 'Excel',
		                //'icon'            => 'file-excel-o',
		                'methods' => [
		                    'SetHeader' => [$pdfHeader],
		                    'SetFooter' => [$pdfFooter]
		                ],
		                'iconOptions'     => ['class' => 'text-success'],
		                'showHeader'      => TRUE,
		                'showPageSummary' => TRUE,
		                'showFooter'      => TRUE,
		                'showCaption'     => TRUE,
		                'filename'        =>  'Accomplishment_Report('.$year.')',
		                'alertMsg'        => 'The EXCEL export file will be generated for download.',
		                'options'         => ['title' => 'Department of Science OneLab'],
		                'mime'            => 'application/vnd.ms-excel',
		                'config'          => [
		                    'worksheet' => 'Accomplishment',
		                    'cssFile'   => ''
		                ]
		            ],
			    ],
		        'columns'=> $gridColumns,
		        'toolbar' => [
	        	'{export}',
	                ],
                'autoXlFormat'=>true,
                'export'=>[
                	'label' => 'Export',
			        'fontAwesome'=>true,
			        'showConfirmAlert'=>false,
			        'target'=>GridView::TARGET_SELF,
			    ],
			    'tableOptions'=>['id'=>'myTable'],
			    ]);
        	?>
    	</div>
     
</div>
</div>

<script type="text/javascript">
	$('#btn-filter').on('click',function(event){
	    event.preventDefault();
	    event.stopImmediatePropagation();
	    if($('#lab_id').val() == ''){
			$('#lab-name').addClass('has-error');
			$('.error-lab').html('Please select laboratory.').fadeIn('fast').fadeOut(3000);
		} else if ($('#the-year').val() == ''){
			$('#the-year').addClass('has-error');
			$('.error-date').html('Please specify year.').fadeIn('fast').fadeOut(3000);
		} else {
			$('#lab-name').removeClass('has-error');
			$('#the-year').removeClass('has-error');
			$('.error-lab').html('');
			$('.error-date').html('');
			$.pjax.reload({container:"#accomplishment-report-pjax",url: '/reports/lab/accomplishment?lab_id='+$('#lab_id').val()+'&year='+$('#the-year').val(),replace:false,timeout: false});
		}
	});

	jQuery(document).ready(function ($) {	


		$('.modal_method').each(function(){	

			$this=$(this.closest('tr')); 	
			 var month = $this.find('td:nth-child(2)').html();	
			 var requests = $this.find('td:nth-child(3)').html();	
			 var samples = $this.find('td:nth-child(4)').html();	
			 var analyses = $this.find('td:nth-child(5)').html();	
			 var fees = $this.find('td:nth-child(6)').html();	
			 var gratis = $this.find('td:nth-child(7)').html();	
			 var discounts = $this.find('td:nth-child(8)').html();	
			 var gross = $this.find('td:nth-child(9)').html();	
			 var data = {"year":<?=$year?>,"month":month,"requests":requests,"samples":samples,"analyses":analyses,"fees":fees,"gratis":gratis,"discounts":discounts,"gross":gross,"labid":<?=$lab_id?>};	
			 $(this).attr('value','/reports/lab/accomplishment/validate?data='+JSON.stringify(data));	

		});	
	});	
</script>
