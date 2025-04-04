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

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Firms/Customers - Accomplishment Report';
$this->params['breadcrumbs'][] = $this->title;

$pdfHeader="OneLab-Enhanced ULIMS";
$pdfFooter="{PAGENO}";
?>


<?php $this->registerJsFile("/js/services/services.js"); ?>
<div class="accomplishment-index">

<fieldset>
        <legend>NOTE</legend>
        <div>
            <span class="badge btn-danger">Not Determined</span>
            <span>- These profiles have no classification yet, updating their profiles will fix the problem.</span>
        </div>
    </fieldset>
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
    	<?= "<h1>For $thislab->labname</h1>" ?>
    
    		<div class="row">
		        

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
			  //   	['class' => 'kartik\grid\ActionColumn',
					// 	'contentOptions' => ['style' => 'width: 8.7%'],
					// 	'template' => '{view}',
					// 	'buttons'=>[
					// 		'view'=>function ($url, $model) use($lab_id) {
					// 			return Html::button('<span class="glyphicon glyphicon-print"></span>', ['value'=>Url::to(['/lab/tagging/monthlyreport','month'=>Yii::$app->formatter->asDate($model->request_datetime, 'php:M'), 'year'=>Yii::$app->formatter->asDate($model->request_datetime, 'php:Y'), 'lab_id' => $lab_id]), 'class' => 'btn btn-primary modal_method','onclick'=>'LoadModal(this.title, this.value ,true, 1850);','title' => Yii::t('app', "Monthly Report")]);
					// 		},
						   
					// 	],
					// ],
			    	'month',
			    	[
			    		'header'=> 'Total No. of Requests/Customer Served',
			    		'contentOptions' => ['class' => 'text-right'],
			    		'attribute' => 'totalrequests',
			    		'pageSummary'=>true,
        				'pageSummaryFunc'=>GridView::F_SUM,
        				'pageSummaryOptions'=>['class'=>'text-right text-primary'],
			    	],
			    	
			    	[
			    		'header'=> 'Unique - Customers Served',
			    		'contentOptions' => ['class' => 'text-right'],
			    		'format' => 'raw',
			    		'value'=> function( $model ) use($year){
			    			$monthyear = $year."-".$model->monthnum;
			    			return Html::a(Html::encode($model->getCustomerStats($monthyear,1)),['shows','monthyear'=>$monthyear,'type'=>1],['target'=>'_blank']);

			    		},

			    	],

			    	[
			    		'header'=> 'Unique - Firms Served',
			    		'contentOptions' => ['class' => 'text-right'],
			    		'format' => 'raw',
			    		'value'=> function( $model ) use($year){
			    			$monthyear = $year."-".$model->monthnum;
			    			return Html::a(Html::encode($model->getCustomerStats($monthyear,2)),['shows','monthyear'=>$monthyear,'type'=>2],['target'=>'_blank']);

			    		},

			    	],

			    	[
			    		'header'=> 'Unique - Not Determined',
			    		'contentOptions' => ['class' => 'text-right'],
			    		'format' => 'raw',
			    		'value'=> function( $model ) use($year){
			    			$monthyear = $year."-".$model->monthnum;
			    			return Html::a(Html::encode($model->getCustomerStats($monthyear,null)),['shows','monthyear'=>$monthyear,'type'=>null],['target'=>'_blank']);

			    		},
	
			    	],

			    	// 'samplescount'
			    ];

			    echo GridView::widget([
			    	'id' => 'accomplishment-report',
			        'dataProvider'=>$dataProvider,
			        //'filterModel'=>$searchModel,
			        'showPageSummary'=>true,
			        'summary' => false,
			        'pjax'=>false,
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


</script>
